$(document).ready(function () {
    echo.init({
        offset: 800,
        throttle: 250,
        unload: false,
    });
});
var texts = [
    "رستوران ها",
    "فست فودها",
    "کبابی ها",
    "همبرگرها",
    "چیزبرگرها",
    "کافه ها",
    "کافه تریاها",
    "پیتزاها",
    "بستنی ها",
    "قنادی ها",
    "چای تلخ",
    "چای سبز",
    "کباب شیشلیک",
    "چلو کباب فیله",
    "چلو کباب برگ",
    "چلو کباب سلطانی",
    "چلو کباب لقمه",
    "چلو کباب کوبیده",
    "باقالا پلو",
    "زرشک پلو",
    "قهوه فرانسه",
    "قهوه ترک",
    "شیشلیک ها",
    "سالاد پاستا",
    "سالاد تبوله عربی",
    "سالاد یونانی",
    "سالاد رژیمی",
    "ترشی کلم قرمز",
    "سالاد شیرازی",
    "کیک خامه‌ ای",
    "کیک شکلاتی",
    "انواع ژله میوه‌ای",
    "میوه‌های فصل",
    "کرم کارامل",
    "عدسی",
    "اسکرامبل تخم مرغ",
    "املت بار و نیمرو",
    "سیب زمینی سوخاری",
    "آب میوه مخلوط",
    "کباب چنجه گیلانه",
    "کباب ترش سنتی",
    "جوجه کباب",
    "کاپوچینوی مخصوص",
    "آیس کافی",
    "آیس لاته",
    "آیس موکا",
    "آیس تی",
    "شکلات تلخ",
    "کوپ بستنی",
    "اسپرسو ماکیاتو",
    "کوکتل میوه",
    "کباب ساندویچ",
    "اسنک فیله مرغ",
    "پیتزا مارگاریتا",
    "پیتزا ایتالیایی",
    "پیتزا سبزیجات",
    "پیتزا قارچ وگوشت",
    "پیتزا قارچ",
    "پیتزا چهارفصل",
    "چیز برگر",
    "ساندویچ فیله",
    "سوخاری",
    "پیتزا گوشت",
    "ساندو یچ چیکن",
    "خوراک کباب",


];
var index = 1;

function showNextQuote() {
    var text = $("#hero-text");
    text.text("کافی شاپ ها");
    var ranNum = Math.floor(Math.random() * texts.length);
    var currentQuote = texts[ranNum];
    text.text(currentQuote)
        .fadeIn(500)
        .delay(1500)
        .fadeOut(500, showNextQuote);

}
showNextQuote();