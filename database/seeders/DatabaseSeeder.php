<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            'courses.view' => 'View courses', 'courses.manage' => 'Create and edit courses',
            'sessions.manage' => 'Schedule and manage live sessions', 'learners.view' => 'View learner profiles',
            'assessments.grade' => 'Grade assessments', 'marketing.manage' => 'Manage public marketing content',
            'reviews.moderate' => 'Moderate course reviews', 'users.manage' => 'Manage users and role assignments',
            'reports.view' => 'View academy reports', 'events.manage' => 'Manage webinars and event registrations',
            'inquiries.manage' => 'Manage contact inquiries', 'cohorts.manage' => 'Manage all cohorts and sessions',
            'assessments.manage' => 'Manage course-wide assessments and quizzes',
            'applications.manage' => 'Review learner job applications and applicant details',
            'audit.view' => 'View staff activity audit history',
        ];

        foreach ($permissions as $name => $label) {
            Permission::updateOrCreate(['name' => $name], ['label' => $label]);
        }

        $bundles = [
            'admin' => ['courses.view', 'courses.manage', 'sessions.manage', 'learners.view', 'assessments.grade', 'marketing.manage', 'reviews.moderate', 'users.manage', 'reports.view', 'events.manage', 'inquiries.manage', 'cohorts.manage', 'assessments.manage', 'applications.manage', 'audit.view'],
            'teacher' => ['courses.view', 'sessions.manage', 'learners.view', 'assessments.grade'],
            'social_manager' => ['courses.view', 'marketing.manage', 'reviews.moderate'],
            'student' => ['courses.view'],
        ];

        foreach ($bundles as $name => $permissionsForRole) {
            $role = Role::updateOrCreate(['name' => $name], ['label' => str($name)->replace('_', ' ')->title()]);
            $role->permissions()->sync(Permission::whereIn('name', $permissionsForRole)->pluck('id'));
        }

        if (app()->environment('local')) {
            $student = User::updateOrCreate(['email' => 'student@northstar.test'], [
                'name' => 'Alex Morgan', 'password' => 'password', 'timezone' => 'Asia/Kolkata', 'email_verified_at' => now(),
            ]);
            $student->roles()->sync(Role::where('name', 'student')->pluck('id'));

            $admin = User::updateOrCreate(['email' => 'admin@northstar.test'], [
                'name' => 'Sam Rivera', 'password' => 'password', 'timezone' => 'Asia/Kolkata', 'email_verified_at' => now(),
            ]);
            $admin->roles()->sync(Role::where('name', 'admin')->pluck('id'));

            $this->call(LiveLearningDemoSeeder::class);
            $this->call(DemoRosterSeeder::class);
            $this->call(AdditionalCoursesSeeder::class);
            $this->call(PurchasableCatalogSeeder::class);
            $this->call(DiscoveryDemoSeeder::class);
            $this->call(InsightsSeeder::class);
        }
    }
}

