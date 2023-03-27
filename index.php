<!DOCTYPE html>
<html>

<head>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<header>
  <div class="p-3 mb-2 bg-primary text-white text-center">
    <h1>MySQL in App Test Web App</h1>
  </div>
</header>

<body>
  <div class="jumbotron">
    <div class="container">
      <h2>Welcome to this page!</h2>

      <?php
      // azure database login
      $azure_mysql_connstr = $_SERVER["MYSQLCONNSTR_localdb"];
      $azure_mysql_connstr_match = preg_match(
        "/" .
          "Database=(?<database>.+);" .
          "Data Source=(?<datasource>.+);" .
          "User Id=(?<userid>.+);" .
          "Password=(?<password>.+)" .
          "/u",
        $azure_mysql_connstr,
        $_
      );

      $dsn = "mysql:host={$_["datasource"]};dbname=test_database;charset=utf8";
      $user = $_["userid"];
      $password = $_["password"];

      $dbh = new PDO($dsn, $user, $password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "INSERT INTO access(timestamp) VALUES(?)";
      $stmt = $dbh->prepare($sql);
      $data[] = date('Y-m-d H:i:s');
      $stmt->execute($data);

      $sql = "SELECT MAX(code) AS LargestPrice FROM access";
      $stmt = $dbh->prepare($sql);
      $stmt->execute();

      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      echo "このページのアクセス回数は";
      echo $rec["LargestPrice"];
      echo "です。";
      ?>
    </div>
  </div>
</body>

</html>