<?php

declare(strict_types=1);

return [
    'common' => [
        'email' => 'Email',
        'password' => 'Password',
        'name' => 'Name',
        'and' => 'and',
        'save' => 'Save',
        'saved' => 'Saved.',
        'cancel' => 'Cancel',
        'close' => 'Close',
        'confirm' => 'Confirm',
        'create' => 'Create',
        'created' => 'Created.',
        'delete' => 'Delete',
        'add' => 'Add',
        'remove' => 'Remove',
        'leave' => 'Leave',
        'done' => 'Done.',
        'enable' => 'Enable',
        'disable' => 'Disable',
        'dismiss' => 'Dismiss',
        'unknown' => 'Unknown',
        'status' => [
            'granted' => 'Granted',
            'denied' => 'Denied',
        ],
    ],
    'flash' => [
        'preferences_updated' => 'Preferences have been updated.',
    ],
    'language' => [
        'application' => 'Application language',
        'polish' => 'Polish',
        'english' => 'English',
    ],
    'theme' => [
        'dark' => 'Dark',
        'light' => 'Light',
        'system' => 'System',
    ],
    'nav' => [
        'debtors' => 'Debtors',
        'profile' => 'Profile',
        'api_tokens' => 'API tokens',
        'logout' => 'Log out',
    ],
    'app' => [
        'workspace' => 'Operations workspace',
        'signed_as' => 'Signed in as :name',
        'dashboard' => 'Business dashboard',
        'footer' => [
            'copyright' => 'Copyright © :year Cross Finance SA',
        ],
    ],
    'debtors' => [
        'title' => 'Debtors',
    ],
    'auth' => [
        'layout' => [
            'subtitle' => 'Comprehensive debt collection system',
            'eyebrow' => 'Authentication',
            'title' =>
                'Cross 2.0 is a comprehensive debt collection system for day-to-day operational work.',
            'description' =>
                'The system keeps daily workflows, data access, and case handling in one consistent business environment prepared for further growth.',
            'operations_title' => '1. Account created by admin',
            'operations_description' =>
                'Access to the system is granted centrally. If you do not have an account yet, contact an administrator.',
            'security_title' => '2. Activate access by email',
            'security_description' =>
                'After the account is created, you will receive an email used to verify your address and activate access.',
            'localization_title' => '3. Set password and sign in',
            'localization_description' =>
                'After activation is completed, you set your own password and only then can enter the panel.',
        ],
        'login' => [
            'title' => 'Sign in',
            'description' => 'Use your credentials to access the operational workspace.',
            'remember' => 'Remember me',
            'forgot_password' => 'Forgot your password?',
            'submit' => 'Sign in',
        ],
        'forgot_password' => [
            'title' => 'Reset password',
            'description' => 'Recover access to your account.',
            'helper' => 'Enter your email address and we will send you a password reset link.',
            'submit' => 'Send reset link',
        ],
        'confirm_password' => [
            'title' => 'Confirm password',
            'description' => 'Protected area confirmation.',
            'helper' => 'Please confirm your password before continuing.',
            'submit' => 'Confirm',
        ],
        'register' => [
            'title' => 'Create account',
            'description' => 'Create a new account for your team workspace.',
            'password_confirmation' => 'Confirm password',
            'terms_prefix' => 'I agree to the',
            'login_link' => 'Already registered?',
            'submit' => 'Create account',
        ],
        'reset_password' => [
            'title' => 'Set a new password',
            'description' => 'Choose a new password for your account.',
            'submit' => 'Save new password',
        ],
        'verify_email' => [
            'title' => 'Verify email address',
            'description' => 'Confirm your email before continuing.',
            'helper' =>
                'Check your inbox and confirm your email address. If the message did not arrive, we can send another verification link.',
            'resent' => 'A new verification link has been sent to your email address.',
            'submit' => 'Resend verification email',
            'edit_profile' => 'Edit profile',
        ],
    ],
    'legal' => [
        'privacy' => [
            'title' => 'Privacy policy',
            'description' => 'Current privacy terms for the Cross system.',
        ],
        'terms' => [
            'title' => 'Terms of service',
            'description' => 'Current service terms for the Cross system.',
        ],
    ],
    'profile' => [
        'title' => 'Profile',
        'overview' => [
            'title' => 'User details',
            'description' => 'Review the account data used in the system.',
            'account_label' => 'User account',
            'email_verified' => 'Email address verified',
            'email_unverified' => 'Email address awaiting verification',
            'fields' => [
                'name' => 'User name',
                'email' => 'Email address',
            ],
        ],
        'password' => [
            'title' => 'Update password',
            'description' => 'Use a strong password to keep your account secure.',
            'current' => 'Current password',
            'new' => 'New password',
        ],
    ],
    'teams' => [
        'common' => [
            'owner' => 'Team owner',
            'name' => 'Team name',
        ],
        'create' => [
            'title' => 'Create team',
            'details_title' => 'Team details',
            'details_description' =>
                'Create a new team for collaboration and operational ownership.',
        ],
        'settings' => [
            'title' => 'Team settings',
            'name_title' => 'Team name',
            'name_description' => 'Update the team name and review owner details.',
        ],
        'members' => [
            'add_title' => 'Add team member',
            'add_description' => 'Invite a new person to collaborate in this team.',
            'add_helper' => 'Provide the email address of the person you want to add to this team.',
            'role' => 'Role',
            'added' => 'Added.',
            'pending_title' => 'Pending invitations',
            'pending_description' =>
                'Invited people can join this team by accepting their invitation email.',
            'list_title' => 'Team members',
            'list_description' => 'All people currently assigned to this team.',
            'manage_role_title' => 'Manage role',
            'leave_title' => 'Leave team',
            'leave_description' => 'Are you sure you want to leave this team?',
            'remove_title' => 'Remove team member',
            'remove_description' => 'Are you sure you want to remove this person from the team?',
        ],
        'delete' => [
            'title' => 'Delete team',
            'description' => 'Permanently delete this team.',
            'helper' =>
                'Deleting a team permanently removes all related resources and data. Download anything you need before continuing.',
            'submit' => 'Delete team',
            'modal_title' => 'Delete team',
            'modal_description' =>
                'Are you sure you want to delete this team? This action permanently removes all related data.',
        ],
    ],
    'api' => [
        'title' => 'API tokens',
        'permissions' => 'Permissions',
        'create' => [
            'title' => 'Create API token',
            'description' =>
                'Allow third-party services to authenticate with your account using dedicated tokens.',
        ],
        'manage' => [
            'title' => 'Manage API tokens',
            'description' => 'Review and remove tokens that are no longer needed.',
            'last_used' => 'Last used :time',
        ],
        'token_value' => [
            'title' => 'API token',
            'description' =>
                'Copy your new API token now. For security reasons it will not be shown again.',
        ],
        'permissions_modal' => [
            'title' => 'API token permissions',
        ],
        'delete' => [
            'title' => 'Delete API token',
            'description' => 'Are you sure you want to delete this API token?',
        ],
    ],
];
