<?php

namespace Tests\Feature;

use App\Http\Controllers\Panel\AttendanceController;
use App\Models\ClassRoom;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceSortingTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $school;
    protected $classRoom;
    protected $lesson;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->school = School::factory()->create();
        $this->user = User::factory()->create([
            'school_id' => $this->school->id,
            'role' => 'teacher'
        ]);
        $this->classRoom = ClassRoom::factory()->create([
            'school_id' => $this->school->id
        ]);
        $this->lesson = Lesson::factory()->create();
    }

    /** @test */
    public function students_are_sorted_correctly_with_mixed_names()
    {
        // ایجاد دانش‌آموزان با نام‌های مختلف
        $students = [
            ['first_name' => 'احمد', 'last_name' => 'محمدی'], // فارسی
            ['first_name' => 'John', 'last_name' => 'Smith'], // انگلیسی
            ['first_name' => 'علی', 'last_name' => 'Ahmad'], // فارسی-انگلیسی
            ['first_name' => 'Mary', 'last_name' => 'احمدی'], // انگلیسی-فارسی
            ['first_name' => 'حسن', 'last_name' => 'رضایی'], // فارسی
            ['first_name' => 'David', 'last_name' => 'Brown'], // انگلیسی
        ];

        foreach ($students as $studentData) {
            $user = User::factory()->create([
                'first_name' => $studentData['first_name'],
                'last_name' => $studentData['last_name']
            ]);
            
            Student::factory()->create([
                'user_id' => $user->id,
                'school_id' => $this->school->id,
                'class_id' => $this->classRoom->id
            ]);
        }

        $response = $this->actingAs($this->user)
            ->get(route('dashboard.attendances.students', $this->classRoom->id));

        $response->assertStatus(200);
        
        $data = $response->json();
        $students = $data['students'];
        
        // بررسی ترتیب صحیح
        $expectedOrder = [
            'احمد محمدی',    // فارسی
            'حسن رضایی',     // فارسی
            'علی Ahmad',     // فارسی-انگلیسی
            'Mary احمدی',    // انگلیسی-فارسی
            'David Brown',   // انگلیسی
            'John Smith',    // انگلیسی
        ];

        $actualOrder = array_map(function($student) {
            return $student['first_name'] . ' ' . $student['last_name'];
        }, $students);

        $this->assertEquals($expectedOrder, $actualOrder);
    }

    /** @test */
    public function name_type_detection_works_correctly()
    {
        $controller = new AttendanceController(
            app(\App\Repositories\StudentsRepository::class),
            app(\App\Repositories\ClassRoomRepository::class),
            app(\App\Services\JalaliDateService::class),
            app(\App\Repositories\LessonsRepository::class),
            app(\App\Repositories\UsersRepository::class),
            app(\App\Repositories\AttendancesRepository::class)
        );

        // استفاده از reflection برای دسترسی به متد private
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('detectNameType');
        $method->setAccessible(true);

        // تست انواع مختلف نام
        $this->assertEquals('persian', $method->invoke($controller, 'احمد محمدی'));
        $this->assertEquals('english', $method->invoke($controller, 'John Smith'));
        $this->assertEquals('mixed_persian_english', $method->invoke($controller, 'علی Ahmad'));
        $this->assertEquals('mixed_english_persian', $method->invoke($controller, 'Mary احمدی'));
    }
}
