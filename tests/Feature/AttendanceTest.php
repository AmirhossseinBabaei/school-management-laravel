<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $school;
    protected $classRoom;
    protected $lesson;
    protected $student;

    protected function setUp(): void
    {
        parent::setUp();
        
        // ایجاد مدرسه
        $this->school = School::factory()->create();
        
        // ایجاد کاربر
        $this->user = User::factory()->create([
            'school_id' => $this->school->id,
            'role' => 'teacher'
        ]);
        
        // ایجاد کلاس
        $this->classRoom = ClassRoom::factory()->create([
            'school_id' => $this->school->id
        ]);
        
        // ایجاد درس
        $this->lesson = Lesson::factory()->create();
        
        // ایجاد دانش‌آموز
        $studentUser = User::factory()->create();
        $this->student = Student::factory()->create([
            'user_id' => $studentUser->id,
            'school_id' => $this->school->id,
            'class_id' => $this->classRoom->id
        ]);
    }

    /** @test */
    public function can_view_attendance_page()
    {
        $response = $this->actingAs($this->user)
            ->get(route('dashboard.attendances.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.attendances.all');
    }

    /** @test */
    public function can_get_students_by_class()
    {
        $response = $this->actingAs($this->user)
            ->get(route('dashboard.attendances.students', $this->classRoom->id));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 1
        ]);
        
        $data = $response->json();
        $this->assertArrayHasKey('students', $data);
        $this->assertCount(1, $data['students']);
    }

    /** @test */
    public function can_store_attendance()
    {
        $attendanceData = [
            'class_id' => $this->classRoom->id,
            'lesson_id' => $this->lesson->id,
            'students' => [
                [
                    'student_id' => $this->student->id,
                    'status' => 'present',
                    'description' => 'حاضر بود'
                ]
            ]
        ];

        $response = $this->actingAs($this->user)
            ->post(route('dashboard.attendances.store'), $attendanceData);

        $response->assertStatus(200);
        $response->assertJson(['status' => 1]);

        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->student->id,
            'class_id' => $this->classRoom->id,
            'lesson_id' => $this->lesson->id,
            'status' => 'present',
            'description' => 'حاضر بود'
        ]);
    }

    /** @test */
    public function validates_required_fields()
    {
        $response = $this->actingAs($this->user)
            ->post(route('dashboard.attendances.store'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['class_id', 'lesson_id', 'students']);
    }

    /** @test */
    public function validates_student_status()
    {
        $attendanceData = [
            'class_id' => $this->classRoom->id,
            'lesson_id' => $this->lesson->id,
            'students' => [
                [
                    'student_id' => $this->student->id,
                    'status' => 'invalid_status',
                    'description' => 'تست'
                ]
            ]
        ];

        $response = $this->actingAs($this->user)
            ->post(route('dashboard.attendances.store'), $attendanceData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['students.0.status']);
    }

    /** @test */
    public function attendance_model_has_correct_relationships()
    {
        $attendance = Attendance::create([
            'school_id' => $this->school->id,
            'student_id' => $this->student->id,
            'class_id' => $this->classRoom->id,
            'lesson_id' => $this->lesson->id,
            'status' => 'present',
            'attendance_by_user_id' => $this->user->id,
            'attended_at' => now(),
            'description' => 'تست'
        ]);

        $this->assertInstanceOf(Student::class, $attendance->student);
        $this->assertInstanceOf(ClassRoom::class, $attendance->classRoom);
        $this->assertInstanceOf(Lesson::class, $attendance->lesson);
        $this->assertInstanceOf(School::class, $attendance->school);
        $this->assertInstanceOf(User::class, $attendance->attendanceByUser);
    }
}
