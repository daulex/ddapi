<?php
// setup
require_once "inc/setup.php";
require_once "inc/utilities.php";

// post types
require_once "post-types/todos.php";
require_once "post-types/todo-templates.php";

// API routes
require_once "routes/reset-password.php";
require_once "routes/register.php";
require_once "routes/verify-email.php";
require_once "routes/todo-update.php";
require_once "routes/todo-get.php";
