//menu
var tombolMenu = $(".tombol-menu");
var menu = $("nav .menu ul");

function klikMenu(){
    tombolMenu.click(function (){
        menu.toggle();
    });
    menu.click(function (){
        menu.toggle();
    });
}

$(document).ready(function() {
   var width =$(window).width();
   if(width < 990){
    klikMenu();
   }
})

//check lebar
$(window).resize(function(){
    var width=$(window).width();
    if(width > 989){
        menu.css("display","block");
        //display:block
    }else{
        menu.css("display","none");
    }
    klikMenu();
});

//efek scroll
$(document).ready(function() {
    var scroll_pos = 0;
    $(document).scroll(function(){
        scroll_pos = $(this).scrollTop();
        if(scroll_pos > 0){
            $("nav").addClass("putih");
            $("nav img.hitam").show();
            $("nav img.putih").hide();
        }else{
            $("nav").removeClass("putih");
            $("nav img.hitam").hide();
            $("nav img.putih ").show();
        }
    })
});

// Fungsi Pencarian
$(document).ready(function () {
    $('#search-button').on('click', function () {
      const query = $('#query').val();
      if (query.trim() !== '') {
        $.ajax({
          url: 'destinasi.php',
          type: 'POST',
          data: { query: query },
          success: function (data) {
            let results = '';
            if (data.length > 0) {
              data.forEach((item) => {
                results += `
                  <div class="destinasi-item">
                    <h4>${item.nama}</h4>
                    <p>${item.deskripsi}</p>
                    <img src="${item.gambar}" alt="${item.nama}" />
                  </div>
                `;
              });
            } else {
              results = '<p>Destinasi tidak ditemukan</p>';
            }
            $('#search-results').html(results);
          },
          error: function () {
            $('#search-results').html('<p>Terjadi kesalahan saat pencarian</p>');
          },
        });
      } else {
        $('#search-results').html('<p>Masukkan kata kunci pencarian</p>');
      }
    });
  });
  