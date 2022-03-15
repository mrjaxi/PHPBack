<?php

$lang['db_invalid_connection_str'] = 'Невозможно определить настройки базы данных на основе предоставленной строки подключения.'; $lang['db_invalid_connection_str'] = 'Невозможно подключиться к серверу базы данных, используя предоставленные настройки.';
$lang['db_unable_to_connect'] = 'Невозможно подключиться к серверу базы данных, используя предоставленные настройки.';
$lang['db_unable_to_select'] = 'Невозможно выбрать указанную базу данных: %s';
$lang['db_unable_to_create'] = 'Невозможно создать указанную базу данных: %s';
$lang['db_invalid_query'] = 'Запрос, который вы отправили, не верен.';
$lang['db_must_set_table'] = 'Вы должны установить таблицу базы данных, которая будет использоваться в вашем запросе.';
$lang['db_must_use_set'] = 'Вы должны использовать метод "set" для обновления записи.';
$lang['db_must_use_index'] = 'Вы должны указать индекс для пакетного обновления.';
$lang['db_batch_missing_index'] = 'В одной или нескольких строках, представленных для пакетного обновления, отсутствует указанный индекс.';
$lang['db_must_use_where'] = 'Обновления не допускаются, если они не содержат предложение "where".';
$lang['db_del_must_use_where'] = 'Удаления не разрешены, если они не содержат условия "where" или "like".';
$lang['db_field_param_missing'] = 'Для извлечения полей требуется имя таблицы в качестве параметра.';
$lang['db_unsupported_function'] = 'Эта функция недоступна для используемой базы данных.';
$lang['db_transaction_failure'] = 'Сбой транзакции: Выполнен откат.';
$lang['db_unable_to_drop'] = 'Невозможно сбросить указанную базу данных.';
$lang['db_unsuported_feature'] = 'Неподдерживаемая функция используемой платформы базы данных.';
$lang['db_unsuported_compression'] = 'Формат сжатия файлов, который вы выбрали, не поддерживается вашим сервером.';
$lang['db_filepath_error'] = 'Невозможно записать данные в указанный вами путь к файлу.';
$lang['db_invalid_cache_path'] = 'Путь к кэшу, который вы предоставили, не действителен или не доступен для записи.';
$lang['db_table_name_required'] = 'Для этой операции требуется имя таблицы.';
$lang['db_column_name_required'] = 'Для этой операции требуется имя столбца.';
$lang['db_column_definition_required'] = 'Для этой операции требуется определение столбца.';
$lang['db_unable_to_set_charset'] = 'Невозможно установить набор символов клиентского соединения: %s';
$lang['db_error_heading'] = 'Произошла ошибка базы данных';

/* End of file db_lang.php */
/* Location: ./system/language/rus/db_lang.php */