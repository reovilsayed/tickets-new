

function updateSearchParams(searchParam, searchValue, route) {
    const url = new URL(window.location.href);
    console.log(window.location.href);
    // const params = new URLSearchParams(url.searchParam);
    url.searchParams.set(searchParam, searchValue);
    const newUrl = url.href;
    window.location = newUrl;
}


function get_filter(class_name) {
    var filter = [];
    $('.' + class_name + ':checked').each(function() {
        filter.push($(this).val());
    });
    return String(filter);
}
$('.common_selector').click(function() {
    filter();
});
$('#min_val').change(function() {
    console.log('sss')
});
function filter() {
    let brands = get_filter('brands');
    let seriess = get_filter('seriess');
    let prodcats = get_filter('prodcats');
    let carriers = get_filter('carriers');
    let min_price = $('#min_val').val();
    let max_price = $('#max_val').val();
    var currentUrl = window.location.href;
    var url = new URL(currentUrl);
    var hidden_minimum_price = get_filter('hidden_minimum_price');
    console.log(hidden_minimum_price);
    //brands
    if (brands) {
        url.searchParams.set("brands", brands);
    } else {
        url.searchParams.delete("brands");
    }
    //series
    if (seriess) {
        url.searchParams.set("seriess", seriess);
    } else {
        url.searchParams.delete("seriess");
    }
    //series
    if (prodcats) {
        url.searchParams.set("prodcats", prodcats);
    } else {
        url.searchParams.delete("prodcats");
    }
    //carriers
    if (carriers) {
        url.searchParams.set("carriers", carriers);
    } else {
        url.searchParams.delete("carriers");
    }
    if (min_price && max_price) {
        url.searchParams.set("min_price", min_price);
        url.searchParams.set("max_price", max_price);
    }
    //price
    var newUrl = url.href;
    window.location = newUrl;
}