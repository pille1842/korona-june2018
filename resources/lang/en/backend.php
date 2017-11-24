<?php

return [

    /*
       |--------------------------------------------------------------------------
       | Backend Language Lines
       |--------------------------------------------------------------------------
       |
       | The following lines are used throughout the backend area of Korona. You
       | are free to modify these lines according to your fraternity's needs.
       |
     */

    'generate_slug' => 'Generate a SEO URL',
    'edit_account' => 'Edit user account :account',
    'save' => 'Save',
    'saved' => 'The changes have been saved.',
    'close' => 'Close',
    'account' => 'User account',
    'password' => 'Password',
    'generate_random_password' => 'Generate a random password',
    'password_email_sent' => 'The new password has been emailed to the user.',
    'newaccount_email_sent' => 'The new user has received an email with his credentials.',
    'create_account' => 'Create new account',
    'user_deleted' => 'The account :account has been moved to the trash.',
    'really_delete_user' => 'Do you really want to delete the account :account?',
    'really_purge_user' => 'Do you really want to purge account :account? This cannot be undone!',
    'restore' => 'Restore',
    'empty_trash' => 'Empty Trash',
    'really_empty_trash' => 'Do you really want to empty the trash? This cannot be undone!',
    'trash' => 'Trash',
    'accounts' => 'User Accounts',
    'normal_view' => 'Normal View',
    'info' => 'Information',
    'enable_password_change' => 'Enable changes',
    'accounts_trash' => 'Trashed User Accounts',
    'user_restored' => 'The account :account has been restored.',
    'edit_member' => 'Edit member :member',
    'profile_picture' => 'Profile picture',
    'personal_details' => 'Personal details',
    'system_details' => 'System properties',
    'members' => 'Members',
    'members_trash' => 'Trashed Members',
    'really_delete_member' => 'Do you really want to delete member :member?',
    'really_purge_member' => 'Do you really want to purge member :member? This cannot be undone!',
    'member_restored' => 'The member :member has been restored.',
    'create_member' => 'Create new member',
    'toggle_navigation' => 'Toggle navigation',
    'backend' => 'Backend',
    'core_data' => 'Core Data',
    'go_to_internal' => 'Go to internal area',
    'logout' => 'Logout',
    'roles_and_permissions' => 'Roles and Permissions',
    'effective_permissions' => 'Effective permissions',
    'has_no_permissions' => 'This user has no permissions.',
    'settings' => 'System Settings',
    'settings_fraternity' => 'Fraternity',
    'system' => 'System',
    'date' => 'Date',
    'user' => 'User',
    'field_name' => 'Field',
    'old_value' => 'Old Value',
    'new_value' => 'New Value',
    'model_created' => 'Has created the record.',
    'model_deleted' => 'Has deleted the record.',
    'model_restored' => 'Has restored the record.',
    'history' => 'Version History',
    'fraternity_details' => 'Fraternity Details',
    'member' => 'Member',
    'settings_mail' => 'Emails',
    'about' => 'Über Korona',
    'role_deleted' => 'Role :role has been deleted.',
    'create_role' => 'Create new role',
    'role' => 'Role',
    'edit_role' => 'Edit role :role',
    'role_permissions' => 'Permissions of this role',
    'role_users' => 'Attached users',
    'role_has_no_permissions' => 'This role has no permissions.',
    'really_delete_role' => 'Do you really want to delete role :role? This cannot be undone!',
    'roles' => 'Roles',
    'active' => 'enabled',
    'inactive' => 'disabled',
    'upload_picture' => 'Upload picture',
    'choose_picture' => 'Choose picture',
    'adopt' => 'Adopt',
    'create_address' => 'Create a new address',
    'addresses' => 'Postal Addresses',
    'edit_address' => 'Edit address :address of :addressable',
    'is_main_address' => 'This is the main address',
    'really_delete_address' => 'Really delete address :address? This cannot be undone!',
    'address_deleted' => 'Address :address has been deleted.',
    'dashboard' => 'Dashboard',
    'about_korona' => 'About Korona',
    'really_delete_phonenumber' => 'Do you really want to delete this phone number? This cannot be undone!',
    'phonenumber_deleted' => 'The phone number has been deleted.',
    'phonenumbers' => 'Phone numbers',
    'add' => 'Add',
    'logs' => 'System Logs',
    'loglevel' => 'Loglevel',
    'logcontext' => 'Context',
    'logdate' => 'Date',
    'logcontent' => 'Message',
    'download_logfile' => 'Download logfile',
    'delete_logfile' => 'Delete logfile',
    'delete_all_logfiles' => 'Delete all logfiles',
    'offices' => 'Offices',
    'really_delete_office' => 'Do you really want to delete this term as :office?',
    'edit_milestonetype' => 'Edit milestone type :milestonetype',
    'create_milestonetype' => 'Create new milestone type',
    'really_delete_milestonetype' => 'Do you really want to delete milestone type :milestonetype? This cannot be undone!',
    'milestonetype_deleted' => 'Milestone type :milestonetype has been deleted.',
    'milestonetypes' => 'Milestone types',
    'preview' => 'Preview',
    'yes' => 'Yes',
    'no' => 'No',
    'trash_emptied' => 'The trash has been emptied.',
    'member_deleted' => 'Member :member has been deleted.',
    'user_purged' => 'User :user has been deleted.',
    'member_purged' => 'Member :member has been permanently deleted.',
    'member_has_no_main_address' => 'None of this member\'s addresses is marked as the main address for receiving letters.',

    'setting' => [
        'fraternity' => [
            'name' => 'Name of the fraternity',
            'home_country' => 'Home country',
            'sex_type' => 'Admittable sexes',
            'has_nicknames' => 'Has nicknames',
            'member_status_enum' => 'Possible values for the member status',
            'vulgo' => 'Prefix for nicknames (e.g. v, al.)',
            'sine_nomine' => 'Suffix für members without nickname (e.g. s.n.)',
            'member_office_enum' => 'Possible offices of a member',
        ],
        'mail' => [
            'member_changed_receivers' => 'Email receivers to notify when a member is changed',
        ],
    ],


    'permissions' => [
        'access' => 'Areas',
        'backend' => 'Backend',
    ],


    'phonenumbertypes' => [
        'HOME' => 'Home',
        'WORK' => 'Workplace',
        'FAX' => 'Fax',
        'FAX_WORK' => 'Fax (workplace)',
        'HOME_MOBILE' => 'Mobile',
        'WORK_MOBILE' => 'Mobile (business)',
        'OTHER' => 'other',
        'OTHER_MOBILE' => 'other (mobile)',
    ],

];
