<?php
require_once dirname(__DIR__) . '/includes/bootstrap.php';
unset($_SESSION['admin_user']);session_regenerate_id(true);flash('success','You have been signed out.');redirect('admin/login.php');
