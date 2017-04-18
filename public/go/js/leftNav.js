/**
 * Created by Administrator on 2017/4/6.
 */
//左侧导航切换
$(function(){
    $(".leftNav .list li .lineBtn.show").on("click",function(){
        $(".leftNav .list li .lineBtn.show").parent("li").removeClass("active");
        $(this).parent("li").addClass("active")
    })
})