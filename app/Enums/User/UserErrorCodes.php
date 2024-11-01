<?php

declare(strict_types=1);

namespace App\Enums\User;

enum UserErrorCodes: string
{
    case NOT_FOUND = 'users.not_found';

    case IDENTICAL_PASSWORDS = 'users.identical_passwords';

    case WRONG_PASSWORD = 'users.wrong_password';

    case BANNED = 'users.banned';

    case DELETED = 'users.deleted';

    case NOT_FOUND_EMAIL = 'users.not_found_email';

    case NOT_APPROPRIATE_ROLE = 'users.not_appropriate_role';

    case PROFILE_NOT_FOUND = 'users.profile_not_found';

    case DUPLICATED_EMAIL = 'users.duplicated_email';

    case DUPLICATED_IDENTIFIER = 'users.duplicated_identifier';

    case IS_NOT_A_MEMBER = 'users.is_not_a_member';

    case IDENTIFIER_REQUIRED = 'users.identifier_required';

    case EMAIL_DOESNT_MATCH = 'users.email_doesnt_match';

    case USER_IS_ALREADY_ASSIGNED_TO_EVENT = 'users.user_is_already_assigned_to_event';
}
