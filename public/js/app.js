function formatNumber(num) {
    if (num == undefined) {
        return '';
    }
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}
function formatDecimal(num) {
    if (num == undefined) {
        return '';
    }
    return parseFloat(num).toFixed(2);
}
function formatUrlTable(code) {
    let urlCode = '<a class="link-code" target="_blank" href="http://s.cafef.vn/hastc/[CODE]-[CODE].chn">[CODE]</a>';
    return urlCode.replace(/\[CODE\]/g, code)
}
function urlOrderStatistics(code) {
    let url = '<a href="/order?code=[CODE]" target="_blank" class="order-link">Orders</a>';
    return url.replace(/\[CODE\]/g, code)
}