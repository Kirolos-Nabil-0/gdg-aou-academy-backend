<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Rate Limiting Messages
    |--------------------------------------------------------------------------
    */
    'rate_limit' => [
        'too_many_requests' => 'Too many requests. Please try again later.',
        'auth_attempts' => 'Too many login attempts. Please try again after :seconds seconds.',
        'retry_after' => 'Please retry after :seconds seconds.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Common Messages
    |--------------------------------------------------------------------------
    */
    'success' => 'Operation completed successfully.',
    'error' => 'An error occurred. Please try again.',
    'unauthorized' => 'Unauthorized access.',
    'forbidden' => 'Access forbidden.',
    'not_found' => 'Resource not found.',
    'validation_error' => 'Validation error.',

    /*
    |--------------------------------------------------------------------------
    | Authentication Messages
    |--------------------------------------------------------------------------
    */
    'auth' => [
        'registration_successful' => 'Registration successful',
        'registration_failed' => 'Registration failed',
        'login_successful' => 'Login successful',
        'logout_successful' => 'Logout successful',
        'logout_all_successful' => 'Logged out from all devices',
        'password_reset_link_sent' => 'Password reset link sent to your email',
        'password_reset_token_generated' => 'Password reset token generated',
        'password_reset_successful' => 'Password reset successful',
        'password_reset_failed' => 'Failed to send password reset link',
        'password_reset_error' => 'Password reset failed',
        'invalid_credentials' => 'Invalid credentials',
        'user_not_found' => 'User not found',
    ],

    /*
    |--------------------------------------------------------------------------
    | College Messages
    |--------------------------------------------------------------------------
    */
    'college' => [
        'retrieved_successfully' => 'Colleges retrieved successfully',
        'not_found' => 'College not found',
    ],

    /*
    |--------------------------------------------------------------------------
    | Track Messages
    |--------------------------------------------------------------------------
    */
    'track' => [
        'retrieved_successfully' => 'Tracks retrieved successfully',
        'not_found' => 'Track not found',
    ],

    /*
    |--------------------------------------------------------------------------
    | Course Messages
    |--------------------------------------------------------------------------
    */
    'course' => [
        'retrieved_successfully' => 'Courses retrieved successfully',
        'not_found' => 'Course not found',
        'created_successfully' => 'Course created successfully',
        'creation_failed' => 'Course creation failed',
        'updated_successfully' => 'Course updated successfully',
        'update_failed' => 'Course update failed',
        'deleted_successfully' => 'Course deleted successfully',
        'deletion_failed' => 'Course deletion failed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Enrollment Messages
    |--------------------------------------------------------------------------
    */
    'enrollment' => [
        'retrieved_successfully' => 'Enrollments retrieved successfully',
        'enrolled_successfully' => 'Enrolled successfully',
        'enrollment_failed' => 'Enrollment failed',
        'already_enrolled' => 'Already enrolled in this course',
        'not_enrollable' => 'This course is not open for enrollment',
        'course_full' => 'Course capacity is full',
        'not_enrolled' => 'Not enrolled in this course',
        'unenrolled_successfully' => 'Unenrolled successfully',
        'unenroll_failed' => 'Unenrollment failed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Messages
    |--------------------------------------------------------------------------
    */
    'session' => [
        'retrieved_successfully' => 'Sessions retrieved successfully',
        'created_successfully' => 'Session created successfully',
        'creation_failed' => 'Session creation failed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Attendance Messages
    |--------------------------------------------------------------------------
    */
    'attendance' => [
        'retrieved_successfully' => 'Attendance retrieved successfully',
        'marked_successfully' => 'Attendance marked successfully',
        'marking_failed' => 'Attendance marking failed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Grade Messages
    |--------------------------------------------------------------------------
    */
    'grade' => [
        'retrieved_successfully' => 'Grades retrieved successfully',
        'submitted_successfully' => 'Grade submitted successfully',
        'submission_failed' => 'Grade submission failed',
    ],

    /*
    |--------------------------------------------------------------------------
    | Certificate Messages
    |--------------------------------------------------------------------------
    */
    'certificate' => [
        'retrieved_successfully' => 'Certificate retrieved successfully',
        'generated_successfully' => 'Certificate generated successfully',
        'generation_failed' => 'Certificate generation failed',
        'already_generated' => 'Certificate already generated for this course',
        'not_eligible' => 'You are not eligible for a certificate (requires 75% attendance and 60% final grade)',
        'not_found' => 'Certificate not found',
        'file_not_found' => 'Certificate file not found',
        'download_failed' => 'Certificate download failed',
        'eligibility_checked' => 'Eligibility checked successfully',
    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard Messages
    |--------------------------------------------------------------------------
    */
    'dashboard' => [
        'retrieved_successfully' => 'Dashboard data retrieved successfully',
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Messages
    |--------------------------------------------------------------------------
    */
    'notification' => [
        'retrieved_successfully' => 'Notifications retrieved successfully',
        'not_found' => 'Notification not found',
        'marked_as_read' => 'Notification marked as read',
        'all_marked_as_read' => 'All notifications marked as read',
        'deleted_successfully' => 'Notification deleted successfully',
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Messages
    |--------------------------------------------------------------------------
    */
    'validation' => [
        'course' => [
            'title_required' => 'Course title is required',
            'track_not_exist' => 'Selected track does not exist',
            'start_date_future' => 'Start date must be today or in the future',
            'end_date_after_start' => 'End date must be after start date',
            'instructor_not_exist' => 'Selected instructor does not exist',
        ],
        'enrollment' => [
            'course_required' => 'Course is required',
            'course_not_exist' => 'Selected course does not exist',
            'user_not_exist' => 'Selected user does not exist',
        ],
        'session' => [
            'course_required' => 'Course is required',
            'course_not_exist' => 'Selected course does not exist',
            'title_required' => 'Session title is required',
            'date_required' => 'Session date is required',
            'date_future' => 'Session date must be today or in the future',
            'duration_required' => 'Duration is required',
        ],
        'attendance' => [
            'session_required' => 'Session is required',
            'session_not_exist' => 'Selected session does not exist',
            'user_required' => 'User is required',
            'user_not_exist' => 'Selected user does not exist',
            'status_required' => 'Attendance status is required',
            'status_invalid' => 'Invalid attendance status',
        ],
        'grade' => [
            'assignment_required' => 'Assignment is required',
            'assignment_not_exist' => 'Selected assignment does not exist',
            'user_required' => 'User is required',
            'user_not_exist' => 'Selected user does not exist',
            'score_required' => 'Score is required',
            'score_numeric' => 'Score must be a number',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | API Messages
    |--------------------------------------------------------------------------
    */
    'api' => [
        'locale_updated' => 'Language preference updated successfully.',
        'invalid_locale' => 'Invalid language code.',
    ],
];
