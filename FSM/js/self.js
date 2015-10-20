/**
 * Created by baiyu04 on 2015/10/9.
 */

function makeHtml_addInterface(interfaceName){
    var result = "";
    var caseNum = 1;
    var div_accordion_group_before = "<div class=\"accordion-group\">\n ";
    var div_accordion_group_end = "</div>\n ";
    var div_accordion_heading_before = "<div class=\"accordion-heading\">\n <a class=\"accordion-toggle\" data-toggle=\"collapse\"data-parent=\"#interfaces\" href=\"#" + interfaceName + "\"> ";
    var div_accordion_heading_end = "</a>\n </div>\n ";
    var div_accordion_body_before = "<div class=\"accordion-body collapse in\" id=\"" + interfaceName + "\" >";
    var div_accordion_body_end = "</div>\n ";

    result = div_accordion_group_before + div_accordion_heading_before + interfaceName + div_accordion_heading_end + div_accordion_body_before;
    for(var i = 0; i < caseNum; i++){
        var div_accordion_inner_before = "<div class=\"accordion-inner\" id=\"" + interfaceName + "_case_" + i + "\">\n ";
        var div_accordion_inner_end = "</div>\n ";
        //从服务端拉取用例名称
        var casename = "";
        result = result + div_accordion_inner_before + casename + div_accordion_inner_end;
    }
    result = result + div_accordion_body_end + div_accordion_group_end;
    return result;
}

$(document).ready(function(){
    /* 展现接口以及各接口用例*/
    //从服务端拉取接口名称
    var inter
    var html = makeHtml_addInterface("test");
    $("#interfaces").append(html);
});

