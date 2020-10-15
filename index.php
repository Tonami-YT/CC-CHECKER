
<head>
  <title>★ Tonami_YT ★ </title>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link href="style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
	<center>
  <br>
    <div class="row col-md-12">
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<div class="card col-sm-8">
  <div class="card-body">
  	<h1>
      <center><span>
          <div class="col-md-8">★ CHECKER BY Tonami_YT ★</center>
    </h1>
   <div class="md-form">
  	 <div class="col-md-12">
  	 &nbsp&nbsp&nbsp
       <textarea  id="lista" style="width: 100%;height: 300px;resize: none; background-color:blue transparent;border: 1px solid black;color:black; "></textarea>
	 </div>
	</div>
    <br>
<center>
 <button class="btn btn-success"  id="testar" onclick="enviar()" >➤ Start</button>
  <button class="btn btn-danger" >➤ Stop</button>
   <p>Select Checker Gate</p>
                    <select class="form-control h-10" id="gate">
                  <option  value="api">GATE 1</option>
                  <option  value="api1">GATE 2</option>
                </select>
</center>
  </div>
</div>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<div class="card col-sm-2">
  <h2 class="badge badge-black">Informations</h2>
  <span>APPROVED CARDS: </span><span id="cLive" class="btn btn-success">0</span>
  <center>CCN MATCHED</center></span><span id="cWarn" class="btn btn-info">0</span>
  <br>
  	<br>
  <span>Declined: </span><span id="cDie"class="btn btn-danger">0</span>
  <span>Tested: </span><span id="total" class="btn btn-warning">0</span>
  <span>Total: </span><span id="carregadas" class="btn btn-dark">0</span>
    <div class="card-body">
</div>
  </div>
</div>
</div>
<br>

<div class="col-md-12">
<div class="card">
<div style="position: absolute;
        top: 0;
        right: 0;">
  <button id="mostra" <button type="button" class="btn btn-primary"> Show / Hide </button>
</div>
  <div class="card-body">
    <h6 style="font-weight: bold;" class="btn btn-success">Approved <span  id="cLive2" class="badge badge-black">0</span></h6>
    <div id="bode"><span id=".aprovadas" class="aprovadas"></span>
</div>
  </div>
</div>
</div>

<div class="col-md-12">
<div class="card">
<div style="position: absolute;
        top: 0;
        right: 0;">
  <button id="mostra3" <button type="button" class="btn btn-primary">Show/Hide</button>
</div>
  <div class="card-body">
    <h6 style="font-weight: bold;" class="btn btn-info">CCN Matched<span  id="cWarn2" class="badge badge-black">0</span></h6>
    <div id="bode3"><span id=".edrovadas" class="edrovadas"></span>
</div>
  </div>
</div>
</div>


<br>
<br>
<br>
<div class="col-md-12">
<div class="card">
  <div style="position: absolute;
        top: 0;
        right: 0;">
  <button id="mostra2" <button type="button" class="btn btn-primary"> Show / Hide </button>
</div>
  <div class="card-body">
    <h6 style="font-weight: bold;" class="btn btn-danger">Declined <span id="cDie2" class="badge badge-black">0</span></h6>
    <div id="bode2"><span id=".reprovadas" class="reprovadas"></span>
    </div>
  </div>
</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script type="text/javascript">

$(document).ready(function(){


    $("#bode").hide();
  $("#esconde").show();
  
  $('#mostra').click(function(){
  $("#bode").slideToggle();
  });
  
   $('#mostra2').click(function(){
  $("#bode2").slideToggle();
  });
  
  
$('#mostra3').click(function(){
  $("#bode3").slideToggle();
  });
  
});

</script>

<script title="ajax do checker">
    function enviar() {
        var linha = $("#lista").val();
        var linhaenviar = linha.split("\n");
        var total = linhaenviar.length;
        var ap = 0;
        var ed = 0;
        var rp = 0;
        linhaenviar.forEach(function(value, index) {
            setTimeout(
                function() {
                	var e = document.getElementById("gate");
              var gate = e.options[e.selectedIndex].value;
                    $.ajax({
                        url: gate + '.php?lista=' + value,
                        type: 'GET',
                        async: true,
                        success: function(resultado) {
                            if (resultado.match("#Approved")) {
                                removelinha();
                                ap++;
                                aprovadas(resultado + "");
                            }else if(resultado.match("#CCN")) {
                                removelinha();
                                ed++;
                                edrovadas(resultado + "");
                           }else {
                                removelinha();
                                rp++;
                                reprovadas(resultado + "");
                            }
                            $('#carregadas').html(total);
                            var fila = parseInt(ap) + parseInt(ed) + parseInt(rp);
                            $('#cLive').html(ap);
                            $('#cWarn').html(ed);
                            $('#cDie').html(rp);
                            $('#total').html(fila);
                            $('#cLive2').html(ap);
                            $('#cWarn2').html(ed);
                            $('#cDie2').html(rp);
                        }
                    });
                }, 2500 * index);
        });
    }
    function aprovadas(str) {
        $(".aprovadas").append(str + "<br>");
    }
    function reprovadas(str) {
        $(".reprovadas").append(str + "<br>");
    }
    function edrovadas(str) {
        $(".edrovadas").append(str + "<br>");
    }
    function removelinha() {
        var lines = $("#lista").val().split('\n');
        lines.splice(0, 1);
        $("#lista").val(lines.join("\n"));
    }
</script>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/js/mdb.min.js"></script>
</body>
<br>
<footer >


    <div class="footer-copyright text-center py-3">
    	<a href="" class="btn btn-secondary active" role="button" aria-pressed="true">CC CHECKER MADE BY @Tonami_YT </a>
	 <h4>STATUS: <span class="badge badge-success">ONLINE</span></h4>
    </div>

  </footer>

</html>