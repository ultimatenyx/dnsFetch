<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DNS Fetch</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/bootstrap4-neon-glow.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel='stylesheet' href='css/hack.min.css'>
    
  </head>
  <body>
  
<div class="container-fluid py-5 mb5">
    <div class="row ht-tm-btn-replaceable ht-tm-needs-darkness mb-5">
        <div class="col-xl-12">
            <h2 class="display-2 ht-tm-component-title">dnsFetch</h2>
        </div>
    </div>
<div class="row ht-tm-btn-replaceable ht-tm-needs-darkness">
    <div class="col-xl-12">
    <form action="">
      <div class="ht-tm-codeblock">
        <div class="ht-tm-element input-group mb-3">
            
          <input type="text" class="form-control form-control-lg" placeholder="Enter a Domain" aria-label="Domain" aria-describedby="basic-addon2" id="domain" name="domain" value="<?php echo @$_GET['domain']; ?>">
          <div class="input-group-append">
            <input class="btn btn-primary" type="submit" value="Go!">
          </div>
          
        </div>
      </div>
    </form>
    </div>
</div>
<div class="row ht-tm-btn-replaceable ht-tm-needs-darkness p-2">
    <div class="col-xl-12">
    <?php

    $domain = @trim($_GET['domain']);
    $domain = str_replace(array("www.","http://www.","https://www.","http://","https://"),"",$domain);
    $wwwdomain = "www.".$domain;
    function displayrecords($rec,$domain){
      $output = [];
      if(!($domain))
        return;
        foreach($rec as $record):
          unset($record['entries']);
            if(in_array($record['type'],array('A','AAAA','CNAME','NS')))
            $output[] = '<h1 class="display-3 ht-tm-element">'.implode($record,' ').'.</h1>';
        endforeach;
        if(empty($output)){
          $output[] = "<h3 class='text-danger'>could not fetch records for ".$domain."</h3>";
        }
        return implode($output,"");
    }
    if($domain):
        $records = dns_get_record($domain);
        // var_dump($records);
        echo displayrecords($records,$domain);
        $www = dns_get_record($wwwdomain,DNS_CNAME);
        // var_dump($www);
        if(empty($www)){
          $www = dns_get_record($wwwdomain,DNS_A);
        }
        echo displayrecords($www,$wwwdomain);
      
    endif;
    ?>
    </div>
</div>
</div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->

  <script src="js/jquery-3.3.1.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

  </body>
</html>