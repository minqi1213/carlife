
var fsm = {};

fsm.init = function(){
    fsm.checker.json.initJsonChecker();
    fsm.checker.database.initDatabaseChecker();
    fsm.relier.initRelier();
}

$(document).ready(function(){
    fsm.init();
});

fsm.checker = {};

fsm.checker.json = {
    initJsonChecker:function(){
        var checkerId = "#json-checker-keyvaleditor";

        var params = {
            placeHolderKey:"Key Of Returned Json",
            placeHolderValue:"Expect Value To Key",
            deleteButton:'<img class="deleteButton" src="img/delete.png">',
            onDeleteRow:function () {},
            onBlurElement:function (){},
        };

        $(checkerId).keyvalueeditor_checker('init', params);

        /*
        $("#tempbutton").on("click",function(){
            var temp = fsm.checker.json.getJsonCheckPoints();
            alert(temp[0].key+" "+temp[0].type+" "+temp[0].value);
        });
        */
    },

    //显示json校验的key value输入框
    openJsonChecker:function(){
        var containerId = "#json-checker-keyvaleditor-containers"
        $(containerId).css("display","block");
    },

    //隐藏json校验的key value输入框
    closeJsonChecker:function(){
        var containerId = "#json-checker-keyvaleditor-containers"
        $(containerId).css("display","none");
    },

    //获取json校验的key value值
    getJsonCheckPoints:function(){
        var checkerId = "#json-checker-keyvaleditor";
        var checkerPoints = $(checkerId).keyvalueeditor_checker("getValues");
        var returnCheckPoints = [];
        for(var i = 0; i < checkerPoints.length; i++ ){
            var checkPoint = {
                key:checkerPoints[i].key,
                value:checkerPoints[i].value,
                type:checkerPoints[i].checkertype,
            };
            returnCheckPoints.push(checkPoint);
        }

        return returnCheckPoints;
    },
};

fsm.checker.database = {
    initDatabaseChecker:function(){
    },
};