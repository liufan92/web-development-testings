$(function() {

    $('#bakery').on('click',setActive);
    $('#places').on('click',setActive);
    $('#about').on('click',setActive);
    
    
    function setActive() {
        $(this).parent().addClass("active");
        $(this).parent().siblings().removeClass("active");
        
    }
}
);