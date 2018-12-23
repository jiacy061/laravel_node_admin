<p id="footer_text">2017-{$nowYear} &copy; <a href="https://jiacyer.com/" target="_blank">Jiacy</a>. All Rights Reserved.</p>

<script type="text/javascript">
    var footer = document.getElementById("footer_text");
    var str = footer.innerHTML;
    // 更新页脚年份
    var today = new Date();
    var nowYear = today.getFullYear();
    if(str.indexOf(nowYear) != -1) {
        // 创建时间与现在同年
        str = "&copy; Since " + nowYear + str.substring(str.indexOf("}") + 1, str.length);
    } else {
        // 创建时间与现在非同年
        str = str.replace("{$nowYear}", nowYear);
    }
    // 更新
    footer.innerHTML = str;
</script>