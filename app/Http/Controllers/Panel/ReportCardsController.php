<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\ClassRoomRepository;
use App\Repositories\DisciplinaryRecordsRepository;
use App\Repositories\GradesRepository;
use App\Repositories\StudentsRepository;
use App\Repositories\TermsRepository;
use App\Repositories\UsersRepository;
use App\Services\JalaliDateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportCardsController extends Controller
{
    protected TermsRepository $termsRepository;
    protected UsersRepository $usersRepository;
    protected StudentsRepository $studentsRepository;
    protected GradesRepository $gradesRepository;
    protected ClassRoomRepository $classRoomRepository;
    protected DisciplinaryRecordsRepository $disciplinaryRecordsRepository;
    protected JalaliDateService $jalaliDateService;

    public function __construct(
        TermsRepository $termsRepository,
        UsersRepository $usersRepository,
        StudentsRepository $studentsRepository,
        GradesRepository $gradesRepository,
        ClassRoomRepository $classRoomRepository,
        DisciplinaryRecordsRepository $disciplinaryRecordsRepository,
        JalaliDateService $jalaliDateService
    ) {
        $this->termsRepository = $termsRepository;
        $this->usersRepository = $usersRepository;
        $this->studentsRepository = $studentsRepository;
        $this->gradesRepository = $gradesRepository;
        $this->classRoomRepository = $classRoomRepository;
        $this->disciplinaryRecordsRepository = $disciplinaryRecordsRepository;
        $this->jalaliDateService = $jalaliDateService;
    }

    public function index()
    {
        // Terms list (scoped to school if needed)
        $terms = $this->termsRepository
            ->setModel()
            ::where('school_id', Auth::user()->school_id)
            ->orderBy('id', 'desc')
            ->get();

        $schoolName = optional(Auth::user()->school)->name ?? '';
        $jyStr = $this->jalaliDateService->now('yyyy');
        $faToEn = ['۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9'];
        $jy = (int) strtr($jyStr, $faToEn);
        // Show as next-current (e.g., 1405-1404)
        $defaultYearRange = (($jy ?: 0) + 1) . '-' . ($jy ?: 0);

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];

        return view('dashboard.reportCards.index', compact('terms', 'schoolName', 'defaultYearRange', 'data'));
    }

    public function fetch(Request $request): JsonResponse
    {
        $request->validate([
            'national_code' => ['required','string'],
            'term_id' => ['required','integer','exists:terms,id'],
            'auto_calculate_disciplinary' => ['sometimes','boolean'],
        ]);

        $nationalCode = $request->input('national_code');
        $termId = (int)$request->input('term_id');
        // Handle boolean from JSON (can be true/false or "true"/"false" string)
        $autoCalculateDisciplinary = filter_var($request->input('auto_calculate_disciplinary', false), FILTER_VALIDATE_BOOLEAN);
        $schoolId = Auth::user()->school_id;

        // Find user by national_code in current school
        $user = $this->usersRepository
            ->setModel()
            ::where('national_code', $nationalCode)
            ->where('school_id', $schoolId)
            ->first();

        if (!$user) {
            return response()->json(['status' => 0, 'message' => 'کاربر یافت نشد']);
        }

        if (Auth::user()->hasRole('student')) {
            if (!($request['national_code'] === Auth::user()->national_code)) {
                return response()->json(['status' => 0, 'message' => 'شماره تلفن با کدملی مطابقت ندارد']);
            }
        }

        // Map to student by user_id
        $student = $this->studentsRepository
            ->setModel()
            ::where('user_id', $user->id)
            ->first();

        if (!$student) {
            return response()->json(['status' => 0, 'message' => 'رکورد دانش‌آموز یافت نشد']);
        }

        // Fetch grades with lesson and class info
        $grades = $this->gradesRepository
            ->setModel()
            ::with('lesson', 'classRoom')
            ->where('student_id', $student->id)
            ->where('term_id', $termId)
            ->orderBy('lesson_id')
            ->get();

        // Get disciplinary records (without date filter to get all records)
        $disciplinaryRecords = collect();
        if ($autoCalculateDisciplinary) {
            // Get all disciplinary records for this student (with score) - no date filter
            $disciplinaryRecords = $this->disciplinaryRecordsRepository
                ->setModel()
                ::where('student_id', $student->id)
                ->whereNotNull('score')
                ->get();
        }

        // Calculate total disciplinary score (starts from 20)
        $totalDisciplinaryScore = 20;
        if ($autoCalculateDisciplinary && $disciplinaryRecords->isNotEmpty()) {
            foreach ($disciplinaryRecords as $record) {
                // Get score value
                $scoreValue = $record->score;

                // Skip if score is null or empty
                if ($scoreValue === null || $scoreValue === '') {
                    continue;
                }

                // Convert to float
                $scoreValue = (float)$scoreValue;

                // Skip if not a valid number
                if (!is_numeric($scoreValue) || $scoreValue < 0) {
                    continue;
                }

                // Get type and normalize it
                $recordType = trim(strtolower($record->type ?? ''));

                // Apply score based on type
                if ($recordType === 'positive') {
                    $totalDisciplinaryScore += $scoreValue;
                } elseif ($recordType === 'negative') {
                    $totalDisciplinaryScore -= $scoreValue;
                }
            }

            // Ensure disciplinary score is between 0 and 20
            if ($totalDisciplinaryScore > 20) {
                $totalDisciplinaryScore = 20;
            }
            if ($totalDisciplinaryScore < 0) {
                $totalDisciplinaryScore = 0;
            }
        }

        // Get the most common class from grades (for disciplinary lesson)
        $mostCommonClass = null;
        if ($grades->isNotEmpty()) {
            $classCounts = [];
            foreach ($grades as $g) {
                $className = $g->classRoom->name ?? $g->classRoom->title ?? null;
                if ($className) {
                    $classCounts[$className] = ($classCounts[$className] ?? 0) + 1;
                }
            }
            if (!empty($classCounts)) {
                $mostCommonClass = array_key_first($classCounts);
                // Get the class with highest count
                arsort($classCounts);
                $mostCommonClass = array_key_first($classCounts);
            }
            // Fallback to first grade's class if no counts
            if (!$mostCommonClass && $grades->first()) {
                $mostCommonClass = $grades->first()->classRoom->name ?? $grades->first()->classRoom->title ?? null;
            }
        }

        $gradesArray = $grades->map(function ($g) use ($disciplinaryRecords, $autoCalculateDisciplinary) {
            $score = (float)$g->score;

            // Calculate disciplinary score adjustments for this lesson
            if ($autoCalculateDisciplinary && $disciplinaryRecords->isNotEmpty()) {
                $lessonDisciplinaryScore = 0;

                foreach ($disciplinaryRecords as $record) {
                    // If lesson_id is null, apply to all lessons; otherwise only to specific lesson
                    if ($record->lesson_id === null || $record->lesson_id == $g->lesson_id) {
                        if ($record->type === 'positive' && $record->score !== null) {
                            $lessonDisciplinaryScore += (float)$record->score;
                        } elseif ($record->type === 'negative' && $record->score !== null) {
                            $lessonDisciplinaryScore -= (float)$record->score;
                        }
                    }
                }

                // Apply disciplinary score adjustment
                $score += $lessonDisciplinaryScore;

                // Ensure score doesn't exceed 20
                if ($score > 20) {
                    $score = 20;
                }

                // Ensure score doesn't go below 0
                if ($score < 0) {
                    $score = 0;
                }
            }

            return [
                'lesson' => $g->lesson->name ?? $g->lesson->title ?? ('درس '.$g->lesson_id),
                'class' => $g->classRoom->name ?? $g->classRoom->title ?? null,
                'score' => $score,
                'description' => $g->description,
            ];
        })->toArray();

        // Add disciplinary lesson as the last item if auto calculate is enabled
        if ($autoCalculateDisciplinary) {
            $gradesArray[] = [
                'lesson' => 'انضباط',
                'class' => $mostCommonClass,
                'score' => $totalDisciplinaryScore,
                'description' => '—',
            ];
        }

        $payload = [
            'status' => 1,
            'student' => [
                'id' => $student->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'national_code' => $user->national_code,
            ],
            'found' => count($gradesArray),
            'grades' => $gradesArray,
        ];

        return response()->json($payload);
    }

    public function classIndex()
    {
        // Terms list (scoped to school if needed)
        $terms = $this->termsRepository
            ->setModel()
            ::where('school_id', Auth::user()->school_id)
            ->orderBy('id', 'desc')
            ->get();

        // Classes list (scoped to school)
        $classes = $this->classRoomRepository
            ->setModel()
            ::where('school_id', Auth::user()->school_id)
            ->orderBy('name')
            ->get();

        $schoolName = optional(Auth::user()->school)->name ?? '';
        $jyStr = $this->jalaliDateService->now('yyyy');
        $faToEn = ['۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9'];
        $jy = (int) strtr($jyStr, $faToEn);
        // Show as next-current (e.g., 1405-1404)
        $defaultYearRange = (($jy ?: 0) + 1) . '-' . ($jy ?: 0);

        $data = [
            'nowDate' => $this->jalaliDateService->now('yyyy/MM/dd')
        ];

        return view('dashboard.reportCards.class', compact('terms', 'classes', 'schoolName', 'defaultYearRange', 'data'));
    }

    public function fetchClass(Request $request): JsonResponse
    {
        $request->validate([
            'class_id' => ['required','integer','exists:classes,id'],
            'term_id' => ['required','integer','exists:terms,id'],
            'auto_calculate_disciplinary' => ['sometimes','boolean'],
        ]);

        $classId = (int)$request->input('class_id');
        $termId = (int)$request->input('term_id');
        // Handle boolean from JSON
        $autoCalculateDisciplinary = filter_var($request->input('auto_calculate_disciplinary', false), FILTER_VALIDATE_BOOLEAN);
        $schoolId = Auth::user()->school_id;

        // Verify class belongs to school
        $classRoom = $this->classRoomRepository
            ->setModel()
            ::where('id', $classId)
            ->where('school_id', $schoolId)
            ->first();

        if (!$classRoom) {
            return response()->json(['status' => 0, 'message' => 'کلاس یافت نشد']);
        }

        // Get all students in this class
        $students = $this->studentsRepository
            ->setModel()
            ::where('class_id', $classId)
            ->where('school_id', $schoolId)
            ->with('user')
            ->get();

        if ($students->isEmpty()) {
            return response()->json(['status' => 0, 'message' => 'دانش‌آموزی در این کلاس یافت نشد']);
        }

        // Fetch report cards for all students
        $reportCards = [];
        foreach ($students as $student) {
            $grades = $this->gradesRepository
                ->setModel()
                ::with('lesson', 'classRoom')
                ->where('student_id', $student->id)
                ->where('term_id', $termId)
                ->orderBy('lesson_id')
                ->get();

            // Get disciplinary records for this student
            $disciplinaryRecords = collect();
            if ($autoCalculateDisciplinary) {
                $disciplinaryRecords = $this->disciplinaryRecordsRepository
                    ->setModel()
                    ::where('student_id', $student->id)
                    ->whereNotNull('score')
                    ->get();
            }

            // Calculate total disciplinary score for this student (starts from 20)
            $totalDisciplinaryScore = 20;
            if ($autoCalculateDisciplinary && $disciplinaryRecords->isNotEmpty()) {
                foreach ($disciplinaryRecords as $record) {
                    $scoreValue = $record->score;
                    if ($scoreValue === null || $scoreValue === '') {
                        continue;
                    }
                    $scoreValue = (float)$scoreValue;
                    if (!is_numeric($scoreValue) || $scoreValue < 0) {
                        continue;
                    }
                    $recordType = trim(strtolower($record->type ?? ''));
                    if ($recordType === 'positive') {
                        $totalDisciplinaryScore += $scoreValue;
                    } elseif ($recordType === 'negative') {
                        $totalDisciplinaryScore -= $scoreValue;
                    }
                }
                if ($totalDisciplinaryScore > 20) {
                    $totalDisciplinaryScore = 20;
                }
                if ($totalDisciplinaryScore < 0) {
                    $totalDisciplinaryScore = 0;
                }
            }

            // Get the most common class from grades (for disciplinary lesson)
            $mostCommonClass = null;
            if ($grades->isNotEmpty()) {
                $classCounts = [];
                foreach ($grades as $g) {
                    $className = $g->classRoom->name ?? $g->classRoom->title ?? null;
                    if ($className) {
                        $classCounts[$className] = ($classCounts[$className] ?? 0) + 1;
                    }
                }
                if (!empty($classCounts)) {
                    arsort($classCounts);
                    $mostCommonClass = array_key_first($classCounts);
                }
                if (!$mostCommonClass && $grades->first()) {
                    $mostCommonClass = $grades->first()->classRoom->name ?? $grades->first()->classRoom->title ?? null;
                }
            }

            // Map grades with disciplinary adjustments
            $gradesArray = $grades->map(function ($g) use ($disciplinaryRecords, $autoCalculateDisciplinary) {
                $score = (float)$g->score;

                // Calculate disciplinary score adjustments for this lesson
                if ($autoCalculateDisciplinary && $disciplinaryRecords->isNotEmpty()) {
                    $lessonDisciplinaryScore = 0;
                    foreach ($disciplinaryRecords as $record) {
                        if ($record->lesson_id === null || $record->lesson_id == $g->lesson_id) {
                            $scoreValue = $record->score;
                            if ($scoreValue !== null && $scoreValue !== '') {
                                $scoreValue = (float)$scoreValue;
                                if (is_numeric($scoreValue) && $scoreValue >= 0) {
                                    $recordType = trim(strtolower($record->type ?? ''));
                                    if ($recordType === 'positive') {
                                        $lessonDisciplinaryScore += $scoreValue;
                                    } elseif ($recordType === 'negative') {
                                        $lessonDisciplinaryScore -= $scoreValue;
                                    }
                                }
                            }
                        }
                    }
                    $score += $lessonDisciplinaryScore;
                    if ($score > 20) {
                        $score = 20;
                    }
                    if ($score < 0) {
                        $score = 0;
                    }
                }

                return [
                    'lesson' => $g->lesson->name ?? $g->lesson->title ?? ('درس '.$g->lesson_id),
                    'class' => $g->classRoom->name ?? $g->classRoom->title ?? null,
                    'score' => $score,
                    'description' => $g->description,
                ];
            })->toArray();

            // Add disciplinary lesson as the last item if auto calculate is enabled
            if ($autoCalculateDisciplinary) {
                $gradesArray[] = [
                    'lesson' => 'انضباط',
                    'class' => $mostCommonClass,
                    'score' => $totalDisciplinaryScore,
                    'description' => '—',
                ];
            }

            $reportCards[] = [
                'student' => [
                    'id' => $student->id,
                    'first_name' => $student->user->first_name ?? '',
                    'last_name' => $student->user->last_name ?? '',
                    'national_code' => $student->user->national_code ?? '',
                ],
                'found' => count($gradesArray),
                'grades' => $gradesArray,
            ];
        }

        $payload = [
            'status' => 1,
            'class_name' => $classRoom->name,
            'report_cards' => $reportCards,
        ];

        return response()->json($payload);
    }
}


