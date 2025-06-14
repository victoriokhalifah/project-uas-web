<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? 'Beritator' ?> | Authentication</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  
  <!-- Custom Red Theme -->
  <style>
    .login-page, .register-page {
      background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    }
    
    .card-outline.card-primary {
      border-top: 3px solid #dc3545;
    }
    
    .btn-primary {
      background-color: #dc3545;
      border-color: #dc3545;
    }
    
    .btn-primary:hover {
      background-color: #c82333;
      border-color: #bd2130;
    }
    
    .btn-outline-light:hover {
      background-color: rgba(255,255,255,0.1);
      border-color: #fff;
    }
    
    .form-control:focus {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .input-group-text {
      background-color: #f8f9fa;
      border-color: #ced4da;
    }
    
    .text-primary {
      color: #dc3545 !important;
    }
    
    a {
      color: #dc3545;
    }
    
    a:hover {
      color: #c82333;
    }
    
    .icheck-primary > input:first-child:checked + label::before {
      background-color: #dc3545;
      border-color: #dc3545;
    }
    
    .card {
      box-shadow: 0 0 20px rgba(220, 53, 69, 0.1);
    }
  </style>
</head>
<body class="hold-transition login-page">

<?= $this->renderSection('content') ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>

</body>
</html>
