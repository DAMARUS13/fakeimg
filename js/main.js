$(function() {

    //ColorPicker Fond
    $('#colorpickerHolder2').ColorPicker({
      flat: true,
      color: '#cccccc',
      onSubmit: function(hsb, hex, rgb) {
        $('#colorSelector2 div').css('backgroundColor', '#' + hex);
        $('#col_fond').val(hex);
        generation();
      }
    });
    $('#colorpickerHolder2>div').css('position', 'absolute');
    var widt = false;
    $('#colorSelector2').bind('click', function() {
      $('#colorpickerHolder2').stop().animate({height: widt ? 0 : 173}, 500);
      widt = !widt;
    });

    //ColorPicker Texte
    $('#colorpickerHolder3').ColorPicker({
      flat: true,
      color: '#cccccc',
      onSubmit: function(hsb, hex, rgb) {
        $('#colorSelector3 div').css('backgroundColor', '#' + hex);
        $('#col_text').val(hex);
        generation();
      }
    });
    $('#colorpickerHolder3>div').css('position', 'absolute');
    var widt = false;
    $('#colorSelector3').bind('click', function() {
      $('#colorpickerHolder3').stop().animate({height: widt ? 0 : 173}, 500);
      widt = !widt;
    });

    // Hauteur
    $("#spin_haut").spinner({
      min:1,
      value:150,
      stop: function(event){
        generation();
        event.stopPropagation();
      }
    });

    // Largeur
    $("#spin_larg").spinner({
      min:1,
      value:150,
      stop: function(event){
        generation();
        event.stopPropagation();
      }
    });

    $("#text").change(function(){
        generation();
    });

    function generation(){
      var url = '',
          haut = $("#spin_haut").spinner("value"),
          larg = $("#spin_larg").spinner("value"),
          col_fond = $('#col_fond').val(),
          col_text = $('#col_text').val(),
          text = $("#text").val();

          haut = haut < 1 ? 150 : haut;
          larg = larg < 1 ? 150 : larg;

          url = 'fakeimg.php?largeur='+larg+'&hauteur='+haut+'&backcolor='+col_fond+'&fontcolor='+col_text;
          url = text != '' ? url + '&text='+text : url;

        $("#lien>a").attr('href',url).text(url);
        $('#img_result').attr('src',url);
    }

});