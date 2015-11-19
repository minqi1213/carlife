
fsm.relier = {
    requestRelyAddId:"request-rely-add",

    initRelier:function(){
        var relierId = "#request-reliance-containers";
        var h = fsm.relier.getRelianceAdderHtml();
        $(relierId).append(h);

        this.addListeners();
    },

    getRelianceAdderHtml: function () {
        var h = "<button class=\"btn request-rely-button\" id=\"request-rely-add\" value=\" + \">+</button>";
        return h;
    },

    getNewRelianceHtml:function(name){
        var h = "<button class=\"btn request-rely-button\" id=" + name + " value=" + name + ">" + name + "</button>"
            + "<button class=\"btn request-rely-close-button close\" id=" + name + "_close value=" + name + "_close>x</button>";
        return h;
    },

    deleteNewRelianceHtml:function(name){
        $("#"+name).remove();
        $("#"+name+"_close").remove();
    },

    addRelianceHandler:function(){

    },

    deleteRelianceHandler:function(){

    },

    addListeners:function(){
        $("#request-rely-add").on("click",function(){
            fsm.relier.addNewReliance("temp");
        });


    },

    addNewReliance:function(name){
        var h = fsm.relier.getNewRelianceHtml(name);
        $("#request-reliance-containers").append(h);

        $("#"+name).on("click",function(){
            alert("111");
        });

        $("#"+name+"_close").on("click",function(){
            fsm.relier.deleteNewRelianceHtml(name);
        });
    },
}