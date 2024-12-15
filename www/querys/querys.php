<?php

/////////////ROOMS////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

define('SQL_GET_ROOMS', '
    SELECT 
        *
    FROM 
        rooms
');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////REGISTER///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('SQL_INSERT_PLAYER', '
    INSERT INTO players (name_player, lastname_player, username, email, password, registration_date)
    VALUES (?, 
            ?, 
            ?, 
            ?, 
            ?, 
            ?)
');

define('SQL_COUNT_USERNAMES', '
    SELECT 
        COUNT(*)
    FROM 
        players
    WHERE 
        username = ?
');

define('SQL_COUNT_EMAILS', '
    SELECT 
        COUNT(*)
    FROM 
        players
    WHERE 
        email = ?
');

define('SQL_INSERT_VERIFICATION_TOKEN', '
        UPDATE 
            usuarios 
        SET 
            token_verificacion = ? 
        WHERE
             email = ?
');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////LOGIN///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('SQL_LOGIN_PLAYERS', '
    SELECT 
        *
    FROM 
        players 
    WHERE
        email = ? OR username = ?
');
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////TRIVIA///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('SQL_GET_RANDOM_QUESTION_OPTIONS', '
    SELECT 
        id_question_option, 
        option_text 
    FROM 
        questions_options 
    WHERE 
        id_question = ? 
    ORDER BY 
        RAND()
');

define('SQL_GET_RANDOM_UNANSWERED_QUESTIONS', '
    SELECT 
        q.id_question, 
        q.question
    FROM 
        questions q
    LEFT JOIN 
        players_answers pa 
    ON 
        q.id_question = pa.id_question 
        AND pa.id_player = ? 
    WHERE 
        q.id_room = ? 
    AND 
        (pa.answer_correct IS NULL OR pa.answer_correct = 0)
    AND 
        NOT EXISTS (
            SELECT 1
            FROM players_answers pa2
            WHERE pa2.id_question = q.id_question
            AND pa2.id_player = ? 
            AND pa2.answer_correct = 1
        )
    GROUP BY
        q.id_question 
    ORDER BY 
        RAND()
    LIMIT 1
');

define('SQL_INSERT_COMPLETED_ROOM', '
    INSERT INTO players_progress (id_player, id_room, room_completed, last_activity_date) 
    VALUES (?, ?, ?, ?)
');


define('SQL_SELECT_COUNT_COMPLETD_ROOM', '
    SELECT COUNT(*) AS 
                        count 
    FROM 
        players_progress 
    WHERE id_player = ? AND id_room = ? AND room_completed = 1
');

define('SQL_GET_CORRECT_ANSWER', '
    SELECT 
        is_correct
    FROM 
        questions_options 
    WHERE 
        id_question_option = ? AND id_question = ?
');

define('SQL_INSERT_ANSWER', '
    INSERT INTO players_answers (answer_correct, time_answer, id_player, id_question, id_question_option, id_room) 
    VALUES (?, ?, ?, ?, ?,?)
');

define('SQL_CHECK_USED_HINT', '
    SELECT used_hint FROM players_progress WHERE id_player = ? AND id_room = ?
');

define('SQL_INSERT_USED_HINT', '
    INSERT INTO players_progress 
    (id_player, id_room, id_question, used_hint, completed, start_date, last_activity_date) 
    VALUES (?, ?, ?, 1, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP) 
    ON DUPLICATE KEY UPDATE used_hint = 1, last_activity_date = CURRENT_TIMESTAMP;
');

define('SQL_SELECT_HINT', '
    SELECT hint FROM hints WHERE id_question = ?
');

define('SQL_INSERT_PROGRESS', '
    INSERT INTO players_progress (id_player, id_room, id_question, completed, start_date, last_activity_date)
    VALUES (?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE 
        completed = VALUES(completed),
        last_activity_date = VALUES(last_activity_date)
');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////SETTINGS///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

define('SQL_GET_PLAYER_DATA', '
    SELECT 
        *
    FROM 
        players
    WHERE 
        id_player = ?
');

define('SQL_UPDATE_PLAYER', '
    UPDATE players
    SET 
        name_player = ?, 
        lastname_player = ?, 
        username = ?, 
        email = ?
    WHERE 
        id_player = ?
');

define('SQL_SELECT_PASSWORD', '
    SELECT 
        password
    FROM    
        players
    WHERE 
        id_player = ?
');

define('SQL_UPDATE_PASSWORD', '
    UPDATE 
        players
    SET 
        password = ?
    WHERE 
        id_player = ? AND password = ?
');

define('SQL_GET_GAME_HISTORY', '
SELECT 
    COUNT(CASE WHEN answer_correct = 1 THEN 1 END) AS correct_answers, 
    COUNT(CASE WHEN answer_correct = 0 THEN 1 END) AS incorrect_answers 
FROM players_answers 
WHERE id_player = ?
');

