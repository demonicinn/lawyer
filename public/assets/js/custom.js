$(document).ready(function() {
    $('.select-block').select2();
});
$(document).ready(function(){
    $('.upcoming').click(function(){
    $('.headng-text-change').text('Upcoming');
    });
      $('.complete').click(function(){
    $('.headng-text-change').text('Complete');
    });
       $('.cases').click(function(){
    $('.headng-text-change').text('Cases');
    });
});
$(document).ready(function(){
    $('.nav-btn').click(function(){
    $('#menu-bar').addClass('active');
    });
    $('.close-menu').click(function(){
        $('#menu-bar').removeClass('active');
    });
    $('#menu-bar .card').click(function(){
        $(this).toggleClass('CollapseActive');
        $(this).nextAll().removeClass('CollapseActive');
        $(this).prevAll().removeClass('CollapseActive');
    });
});
$(document).ready(function(){
    $('.toggle_cstm-btn').click(function(){
        for ( item of $(".reshedule_wrap-box") ){ console.log( $(item).removeClass('active') ); }
        $(this).next().toggleClass('active');
    });
    $('.cancel_btn').click(function(){
        $(this).parents('.reshedule_wrap-box').removeClass('active');
    });
});
// Price Range Slider
const range = document.getElementById('range'),
tooltip = document.getElementById('hourly-range'),
setValue = ()=>{
    const
        newValue = Number( (range.value - range.min) * 100 / (range.max - range.min) ),
        newPosition = 16 - (newValue * 0.32);
    tooltip.innerHTML = `<span>$${range.value}</span>`;
    tooltip.style.left = `calc(${newValue}% + (${newPosition}px))`;
    document.getElementById('hourly-rate-slider').style.setProperty("--range-progress", `calc(${newValue}% + (${newPosition}px))`);
};
document.addEventListener("DOMContentLoaded", setValue);
document.getElementById('range').addEventListener('input', setValue);


// Experience Range Slider
const Experiencerange = document.getElementById('experience-range'),
Experiencetooltip = document.getElementById('experience-range-tooltip'),
ExperiencesetValue = ()=>{
    const
        ExpnewValue = Number( (Experiencerange.value - Experiencerange.min) * 100 / (Experiencerange.max - Experiencerange.min) ),
        ExpnewPosition = 2 - (ExpnewValue * 0.1);
        Experiencetooltip.innerHTML = `<span>${Experiencerange.value} yrs</span>`;
        Experiencetooltip.style.left = `calc(${ExpnewValue}% + (${ExpnewPosition}px))`;
    document.getElementById('years-experience-slider').style.setProperty("--range-progress", `calc(${ExpnewValue}% + (${ExpnewPosition}px))`);
};
document.addEventListener("DOMContentLoaded", ExperiencesetValue);
document.getElementById('experience-range').addEventListener('input', ExperiencesetValue);

// Distance Range Slider
const distancerange = document.getElementById('distance-range'),
distancetooltip = document.getElementById('distance-range-tooltip'),
distancesetValue = ()=>{
    const
        distaneValue = Number( (distancerange.value - distancerange.min) * 100 / (distancerange.max - distancerange.min) ),
        distancePosition = 2 - (distaneValue * 0.1);
        distancetooltip.innerHTML = `<span>${distancerange.value} miles</span>`;
        distancetooltip.style.left = `calc(${distaneValue}% + (${distancePosition}px))`;
    document.getElementById('distance-range-slides').style.setProperty("--range-progress", `calc(${distaneValue}% + (${distancePosition}px))`);
};
document.addEventListener("DOMContentLoaded", distancesetValue);
document.getElementById('distance-range').addEventListener('input', distancesetValue);
// Pagination Js
var items = $(".list-service .list-service-item");
    var numItems = items.length;
    var perPage = 6;

    items.slice(perPage).hide();

    $('.pagination-container-service').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function (pageNumber) {
            var showFrom = perPage * (pageNumber - 1);
            var showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
        }
    });
    