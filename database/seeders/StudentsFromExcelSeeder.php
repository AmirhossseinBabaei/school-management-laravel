<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Shuchkin\SimpleXLSX;

class StudentsFromExcelSeeder extends Seeder
{
    /**
     * Normalize Persian/Arabic digits to English digits.
     */
    protected function normalizeDigits(string $value): string
    {
        $persian = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $english = ['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'];
        return str_replace($persian, $english, $value);
    }

    /**
     * Process only these class numbers (order respected).
     * Leave empty to process all detected classes.
     */
    protected array $onlyClasses = ['704'];

    /**
     * Map visible class titles/numbers in the Excel to actual class IDs in DB.
     * Fill this based on your database.
     *
     * Example:
     *  '704' => 12,
     *  '705' => 13,
     */
    protected array $classNameToId = [
         '704' => 2,
         '705' => 3,
         '706' => 4,
         '804' => 5,
         '805' => 6,
         '806' => 7,
         '904' => 8,
         '905' => 9,
         '906' => 10,
    ];

    /**
     * Absolute or relative filename to read from public/excell.
     * If empty, the first .xlsx/.xls file in public/excell will be used.
     */
    protected string $fileName = '';

    public function run(): void
    {
        $excelPath = public_path('excell');
        if (!File::exists($excelPath) || !File::isDirectory($excelPath)) {
            $this->command->error('Directory not found: ' . $excelPath);
            return;
        }

        $filePath = '';
        if ($this->fileName !== '') {
            $filePath = $excelPath . DIRECTORY_SEPARATOR . $this->fileName;
            if (!File::exists($filePath)) {
                $this->command->error('File not found: ' . $filePath);
                return;
            }
        } else {
            // Pick first excel file
            $candidates = array_merge(
                File::glob($excelPath . DIRECTORY_SEPARATOR . '*.xlsx') ?: [],
                File::glob($excelPath . DIRECTORY_SEPARATOR . '*.xls') ?: []
            );
            if (empty($candidates)) {
                $this->command->error('No Excel files found in: ' . $excelPath);
                return;
            }
            $filePath = $candidates[0];
        }

        $this->command->info('Reading: ' . $filePath);

        if (!$xlsx = SimpleXLSX::parse($filePath)) {
            $this->command->error('XLSX parse error: ' . SimpleXLSX::parseError());
            return;
        }

        $rows = $xlsx->rows();
        if (empty($rows)) {
            $this->command->error('Excel is empty.');
            return;
        }

        $firstRow = $rows[0];
        $colCount = count($firstRow);
        $rowCount = count($rows);

        // Detect class headers across the first few rows (to handle merged cells or title offset)
        // We'll scan rows 0..5 and choose the row with the most 3-4 digit numbers as headers.
        $bestHeaderRowIndex = null;
        $bestHeaderRowCount = -1;
        $candidateHeadersByRow = []; // rowIndex => [colIndex => digits]
        $scanRows = min(6, $rowCount);
        for ($r = 0; $r < $scanRows; $r++) {
            $row = $rows[$r];
            $map = [];
            for ($c = 0; $c < $colCount; $c++) {
                $raw = isset($row[$c]) ? trim((string)$row[$c]) : '';
                if ($raw === '') {
                    continue;
                }
                $raw = $this->normalizeDigits($raw);
                // Extract 3-4 digit sequences
                $digits = preg_replace('/\D+/', '', $raw);
                if ($digits !== '' && preg_match('/^\d{3,4}$/', $digits)) {
                    $map[$c] = $digits;
                }
            }
            $candidateHeadersByRow[$r] = $map;
            if (count($map) > $bestHeaderRowCount) {
                $bestHeaderRowCount = count($map);
                $bestHeaderRowIndex = $r;
            }
        }

        $classHeaders = $candidateHeadersByRow[$bestHeaderRowIndex] ?? [];
        if (empty($classHeaders)) {
            $this->command->error('No class headers detected in the first 6 rows.');
            return;
        }
        $this->command->info('Detected class headers on row index: ' . $bestHeaderRowIndex);

        $totalUpserts = 0;
        $skipped = [];

        // Respect processing order if $onlyClasses is set
        $orderedHeaders = $classHeaders;
        if (!empty($this->onlyClasses)) {
            $orderedHeaders = [];
            foreach ($this->onlyClasses as $want) {
                foreach ($classHeaders as $col => $digits) {
                    if ($digits === $want) {
                        $orderedHeaders[$col] = $digits;
                    }
                }
            }
        }

        foreach ($orderedHeaders as $startCol => $classDigits) {
            $classSuccess = 0;
            $classSkips = 0;
            $detectedCodes = [];
            $missingCodes = [];
            // Resolve class_id using provided mapping; fallback to DB lookup by name like %digits%
            $classId = $this->classNameToId[$classDigits] ?? null;
            if ($classId === null || $classId === 0) {
                $class = ClassRoom::where('name', 'like', '%' . $classDigits . '%')->first();
                $classId = $class?->id;
            }
            if (!$classId) {
                $skipped[] = "Class '{$classDigits}' not found/mapped.";
                continue;
            }

            // Determine block width: until next header or small cap
            $nextCols = array_values(array_filter(array_keys($classHeaders), fn($c) => $c > $startCol));
            $endCol = ($nextCols !== [])
                ? (min($nextCols) - 1)
                : ($colCount - 1);

            // Iterate rows; for each row, scan the block columns and pick the first 10-digit national code found
            for ($r = $bestHeaderRowIndex + 1; $r < $rowCount; $r++) {
                $nationalCode = '';
                for ($c = $startCol; $c <= $endCol; $c++) {
                    $cell = isset($rows[$r][$c]) ? trim((string)$rows[$r][$c]) : '';
                    if ($cell === '') {
                        continue;
                    }
                    $cell = $this->normalizeDigits($cell);
                    // Extract digits from the cell to be robust against formatting
                    $digitsOnly = preg_replace('/\D+/', '', $cell);
                    if ($digitsOnly === '') {
                        continue;
                    }
                    if (strlen($digitsOnly) === 10) {
                        $nationalCode = $digitsOnly;
                        break;
                    }
                    // Occasionally Excel drops a leading zero -> 9 digits. Try left-pad.
                    if (strlen($digitsOnly) === 9) {
                        $nationalCode = '0' . $digitsOnly;
                        break;
                    }
                }
                if ($nationalCode === '' || !preg_match('/^\d{10}$/', $nationalCode)) {
                    continue;
                }
                $detectedCodes[] = $nationalCode;

                $user = User::where('national_code', $nationalCode)->first();
                if (!$user) {
                    $skipped[] = "User not found for national_code {$nationalCode} (class {$classDigits})";
                    $missingCodes[] = $nationalCode;
                    $classSkips++;
                    continue;
                }

                $student = Student::firstOrNew(['user_id' => $user->id]);
                if (!$student->exists) {
                    $student->school_id = $user->school_id;
                }
                $student->class_id = $classId;
                $student->save();
                $totalUpserts++;
                $classSuccess++;
            }

            $detectedCount = count($detectedCodes);
            $this->command->info("Class {$classDigits}: detected {$detectedCount} rows, inserted/updated {$classSuccess}, skipped {$classSkips}.");
            if (!empty($missingCodes)) {
                $this->command->warn("Class {$classDigits}: missing users for national_codes: " . implode(',', array_slice($missingCodes, 0, 25)) . (count($missingCodes) > 25 ? ' ...' : ''));
            }
        }

        $this->command->info("Students import done. Upserted: {$totalUpserts}");
        if (!empty($skipped)) {
            foreach ($skipped as $msg) {
                $this->command->warn($msg);
            }
        }
    }
}


