<?php

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

define('SQL_GET_ROOMS', '
    SELECT 
        r.name, 
        r.description, 
        d.id_difficulty 
    FROM 
        rooms r
    JOIN 
        difficulties d ON r.id_difficulty = d.id_difficulty
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