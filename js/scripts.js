$(document).ready(function(){
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
  })

  var div = document.getElementById("history");
  if(div != null){
  $('html, body').animate({scrollTop: $("#scroll").offset().top}, 'slow');
  div.scrollTop = div.scrollHeight - div.clientHeight;
  }

  $("input:checkbox").change(function() {
    checkboxHTML = $('#checkboxHTML').prop('checked');
    if(checkboxHTML == true){
      $('#habiAtual').val("HTML");
    }

    phpIsChecked = $('#checkboxPHP').prop('checked');
    if(phpIsChecked == true){
       $('#habiAtual').val($('#habiAtual').val() + ',PHP');
    }

    checkboxSQL = $('#checkboxSQL').prop('checked');
    if(checkboxSQL == true){
       $('#habiAtual').val($('#habiAtual').val() + ',SQL');
    }

    checkboxBOT = $('#checkboxBOT').prop('checked');
    if(checkboxBOT == true){
       $('#habiAtual').val($('#habiAtual').val() + ',Bootstrap');
    }

    checkboxCSS = $('#checkboxCSS').prop('checked');
    if(checkboxCSS == true){
       $('#habiAtual').val($('#habiAtual').val() + ',CSS');
    }

    checkboxJS = $('#checkboxJS').prop('checked');
    if(checkboxJS == true){
       $('#habiAtual').val($('#habiAtual').val() + ',JavaScript');
    }

    checkboxJquery = $('#checkboxJquery').prop('checked');
    if(checkboxJquery == true){
       $('#habiAtual').val($('#habiAtual').val() + ',Jquery');
    }

    checkboxAJAX = $('#checkboxAJAX').prop('checked');
    if(checkboxAJAX == true){
       $('#habiAtual').val($('#habiAtual').val() + ',Ajax');
    }

    checkboxC = $('#checkboxC').prop('checked');
    if(checkboxC == true){
       $('#habiAtual').val($('#habiAtual').val() + ',C#');
    }

    checkboxCplusplus = $('#checkboxCplusplus').prop('checked');
    if(checkboxCplusplus == true){
       $('#habiAtual').val($('#habiAtual').val() + ',C++');
    }

    checkboxPhyton = $('#checkboxPhyton').prop('checked');
    if(checkboxPhyton == true){
       $('#habiAtual').val($('#habiAtual').val() + ',Phyton');
    }

    checkboxAndroid = $('#checkboxAndroid').prop('checked');
    if(checkboxAndroid == true){
       $('#habiAtual').val($('#habiAtual').val() + ',Android');
    } 
  }).change();

	tinymce.init({
  selector: 'textarea#editable',
  plugins: [
    'advlist autolink lists link image charmap  preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'preview media | forecolor backcolor emoticons | codesample' });

  //ADMCP

  $("#content-menu").show();
  $("#menu-adm").html("<a class='active'>MENU <i class='fas fa-plus float-right'></i></a>");
  $(".categorias li").hide();
  $(".forums li").hide();
  $(".topicos li").hide();
  $(".usuarios li").hide();
  $(".chatboxa li").hide();
  $(".nreputacao li").hide();
  $(".configs-site li").hide();


  $("#menu-adm").click(function(){
    if ($("#content-menu").is(":hidden")){
      $("#menu-adm").html("<a class='active'>ESCONDER MENU <i class='fas fa-minus float-right'></i></a>");
      $("#content-menu").slideDown("slow");
    }else{
      $("#content-menu").hide("slow");
      $("#menu-adm").html("<a class='active'>MOSTRAR MENU <i class='fas fa-plus float-right'></i></a>");
    }
  });   

  $(".categorias").click(function(){
    if ($(".categorias li").is(":hidden")){
      $(".categorias li").slideDown("slow");
    }else{
      $(".categorias li").hide("slow");
    }
  }); 

  $(".forums").click(function(){
    if ($(".forums li").is(":hidden")){
      $(".forums li").slideDown("slow");
    }else{
      $(".forums li").hide("slow");
    }
  }); 

  $(".topicos").click(function(){
    if ($(".topicos li").is(":hidden")){
      $(".topicos li").slideDown("slow");
    }else{
      $(".topicos li").hide("slow");
    }
  }); 

  $(".usuarios").click(function(){
    if ($(".usuarios li").is(":hidden")){
      $(".usuarios li").slideDown("slow");
    }else{
      $(".usuarios li").hide("slow");
    }
  }); 

  $(".chatboxa").click(function(){
    if ($(".chatboxa li").is(":hidden")){
      $(".chatboxa li").slideDown("slow");
    }else{
      $(".chatboxa li").hide("slow");
    }
  }); 

    $(".nreputacao").click(function(){
    if ($(".nreputacao li").is(":hidden")){
      $(".nreputacao li").slideDown("slow");
    }else{
      $(".nreputacao li").hide("slow");
    }
  }); 

  $(".configs-site").click(function(){
    if ($(".configs-site li").is(":hidden")){
      $(".configs-site li").slideDown("slow");
    }else{
      $(".configs-site li").hide("slow");
    }
  }); 

  var textcolor = null;
  var bgcolor = null;

document.getElementById('color').onchange=function(){
  //this.value
  textcolor = this.value;
  $("#previewcolor").html("Preview: <span style='background-color:"+bgcolor+"; color:"+textcolor+"; padding: 5px;'> NOVO NIVEL </span><br><br>");
}

document.getElementById('bg_color').onchange=function(){
  //this.value
  bgcolor = this.value;
  $("#previewcolor").html("Preview: <span style='background-color:"+bgcolor+"; color:"+textcolor+"; padding: 5px;'> NOVO NIVEL </span><br><br>");
}


});







