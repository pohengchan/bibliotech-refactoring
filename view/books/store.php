<?php
require_once("c://xampp/htdocs/bibliotech-refactoring/controller/BookController.php");

$controller = new BookController();
if (isset($_POST['save_book'])) {
    $errors = [];
    $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : null;
    if (!is_numeric($isbn)) {
        $errors['isbn'] = 'El isbn de contener solo numeros enteros.';
    }

    $isbncheck = $controller->searchIsbn($isbn);
    if ( $isbncheck[0] == "1") {
        $errors['isbn'] = 'Este isbn ya existe';
    }


    if (empty($errors)){
        $controller->addBooks(
            isset($_POST['isbn']) ? $_POST['isbn'] : null,
            $_POST['title'],
            $_POST['author_name'],
            $_POST['author_lastname'],
            $_POST['description'],
            'assets/img/'.basename($_FILES['image']['name'])
        );
        $image_name = basename($_FILES['image']['name']);
        $image_file = $_FILES['image']['tmp_name'];
        
        $directory_route = '/bibliotech-refactoring/assets/img/' . $image_name;
        $db_image_route = 'assets/img/' . $image_name;
        move_uploaded_file($image_file, 'assets/img/'.basename($_FILES['image']['name']));
    }
    require('c://xampp/htdocs/bibliotech-refactoring/view/books/create.php');
}