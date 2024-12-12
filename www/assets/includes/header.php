<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href="../assets/img/logo.png" type="">
    <title>EscapeRoom</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css" />
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link href="../assets/css/responsive.css" rel="stylesheet" />
    <style>
    .trivia-section {
        background-color: #040404;
        color: white;
        padding: 30px;
        margin-top: 30px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
        position: relative;
        min-height: 400px;
    }

    .trivia-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #111;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .timer {
        font-size: 18px;
        font-weight: bold;
    }

    .btn-exit {
        background-color: #111;
        border: none;
        padding: 10px 20px;
        color: white;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        text-transform: uppercase;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-exit:hover {
        background-color: #c0392b;
    }


    .trivia-content {
        display: flex; /* Flexbox para alinear el contenido */
        flex-direction: column; /* Disposición en columna */
        justify-content: center; /* Centra verticalmente el contenido */
        align-items: center; /* Centra horizontalmente el contenido */
        text-align: center;
    }

    .trivia-question {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        text-transform: uppercase; /* Pone la pregunta en mayúsculas */
    }

    .trivia-options {
        display: flex;
        justify-content: center; /* Centra las opciones horizontalmente */
        margin-bottom: 20px;
    }

    .option-container {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 300px; /* Limita el ancho máximo de cada opción */
        margin: 5px 0;
    }

    .trivia-options label {
    display: inline-flex;
    align-items: center;
    font-size: 18px; /* Tamaño de fuente fijo */
    background-color: #f39c12;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    width: 100%; /* Asegura que las opciones ocupen todo el ancho disponible */
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    border: 2px solid #f39c12;
    text-align: center; /* Centra el texto en el label */
    box-sizing: border-box; /* Incluye el padding en el cálculo del ancho */
}

.trivia-options label {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 60px; /* Ajusta la altura para que todos los labels tengan la misma */
    text-align: center; /* Centra el texto dentro del label */
    padding: 0 15px; /* Ajuste del padding si es necesario */
}


    .trivia-options input[type="radio"] {
        visibility: hidden; /* Ocultar el botón de radio */
    }

    .trivia-options label:hover {
        background-color: #e67e22; /* Cambio de color cuando el usuario pasa el ratón */
    }

    /* Cambiar color de la opción seleccionada */
    .trivia-options input[type="radio"]:checked + label {
        background-color: #d35400; /* Color más oscuro cuando se selecciona la opción */
        transform: scale(1.05); /* Efecto de aumento */
    }

    .btn-submit {
        background-color: #f39c12;
        border: none;
        padding: 12px 30px;
        font-size: 18px;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 20px;
        display: block;
        width: 200px;
        margin-left: auto;
        margin-right: auto; /* Centrado horizontal del botón */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        font-weight: bold;
        text-transform: uppercase;
        color:white;
    }

    .btn-submit:hover {
        background-color: #e67e22;
    }

    .hero_area {
        position: relative;
    }

    .heading_container {
        text-align: center;
        margin-bottom: 30px;
        background-color: #f39c12;
        padding: 20px;
        border-radius: 10px;
        color: white;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .heading_container h2 {
        font-size: 36px;
        color: white;
        text-transform: uppercase;
    }

    /* Media Queries para pantallas pequeñas */
    @media (max-width: 768px) {
        .trivia-section {
            margin-top: 10px; /* Reducimos el margen superior */
            padding: 15px;
        }

        .trivia-question {
            font-size: 18px; /* Ajustamos el tamaño de la pregunta */
        }

        .btn-submit {
            width: 100%; /* Hacemos que el botón ocupe todo el ancho */
        }
        .trivia-options {
        display: flex;
        flex-wrap: wrap;   /*Permite que las opciones se apilen en pantallas pequeñas */
        justify-content: center; /* Centra las opciones horizontalmente */
        margin-bottom: 20px;
        width: 100%;
        }

        .trivia-options label {
            font-size: 16px; /* Reducimos el tamaño de las opciones */
            padding: 8px 10px;
            width: 100%; /* Hacemos que las opciones se adapten a la pantalla */
        }

        .option-container {
            width: 100%; /* Asegura que las opciones ocupen todo el ancho disponible */
        }
    }
</style>
</head>

