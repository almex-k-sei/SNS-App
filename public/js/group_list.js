'use strict';
// モーダルウィンドウのトリガーボタンを取得
var modalBtns = document.getElementsByClassName("modalBtn");

// モーダルウィンドウの要素を取得
var modals = document.getElementsByClassName("modal");

// 閉じるボタンを取得
var closeBtns = document.getElementsByClassName("close");

var divA = document.getElementsByClassName("main_before");
var divB = document.getElementsByClassName("add_before_button");
var divC = document.getElementsByClassName("add_after");
var divD = document.getElementsByClassName("edit_before_button");
var divE = document.getElementsByClassName("edit_after");
var divF = document.getElementsByClassName("delete_before_button");
var divG = document.getElementsByClassName("delete_after");

// トリガーボタンがクリックされた時の処理
for (var i = 0; i < modalBtns.length; i++) {
    modalBtns[i].onclick = function() {
        var modal = this.nextElementSibling;
        modal.style.display = "block"; // 対応するモーダルを表示する
    };
}


// 閉じるボタンがクリックされた時の処理
for (var i = 0; i < closeBtns.length; i++) {

    closeBtns[i].onclick = function() {
        var modal = this.parentNode.parentNode;
        modal.style.display = "none"; // 対応するモーダルを非表示にする
        for (var i = 0; i < divA.length; i++) {
            divA[i].style.display = "block";
        }

        for (var j = 0; j < divB.length; j++) {
            divB[j].style.display = "block";
        }

        for (var k = 0; k < divC.length; k++) {
            divC[k].style.display = "none";
        }
        for (var j = 0; j < divD.length; j++) {
            divD[j].style.display = "block";
        }

        for (var k = 0; k < divE.length; k++) {
            divE[k].style.display = "none";
        }
        for (var j = 0; j < divD.length; j++) {
            divF[j].style.display = "block";
        }

        for (var k = 0; k < divE.length; k++) {
            divG[k].style.display = "none";
        }
    };
}

// モーダルウィンドウの外側がクリックされた時の処理
window.onclick = function(event) {
    for (var i = 0; i < modals.length; i++) {
        if (event.target == modals[i]) {
            modals[i].style.display = "none"; // 対応するモーダルを非表示にする
            for (var i = 0; i < divA.length; i++) {
                divA[i].style.display = "block";
            }

            for (var j = 0; j < divB.length; j++) {
                divB[j].style.display = "block";
            }

            for (var k = 0; k < divC.length; k++) {
                divC[k].style.display = "none";
            }
            for (var j = 0; j < divD.length; j++) {
                divD[j].style.display = "block";
            }

            for (var k = 0; k < divE.length; k++) {
                divE[k].style.display = "none";
            }
            for (var j = 0; j < divD.length; j++) {
                divF[j].style.display = "block";
            }

            for (var k = 0; k < divE.length; k++) {
                divG[k].style.display = "none";
            }
        }
    }
};

function AddMember() {
    var divA = document.getElementsByClassName("main_before");
    var divB = document.getElementsByClassName("add_before_button");
    var divC = document.getElementsByClassName("add_after");

    for (var i = 0; i < divA.length; i++) {
        divA[i].style.display = "none";
    }

    for (var j = 0; j < divB.length; j++) {
        divB[j].style.display = "none";
    }

    for (var k = 0; k < divC.length; k++) {
        divC[k].style.display = "block";
    }
}


function EditMember() {
    var divA = document.getElementsByClassName("main_before");
    var divB = document.getElementsByClassName("edit_before_button");
    var divC = document.getElementsByClassName("edit_after");
    var divE = document.getElementsByClassName("delete_before_button");
    for (var i = 0; i < divA.length; i++) {
        divA[i].style.display = "none";
    }

    for (var j = 0; j < divB.length; j++) {
        divB[j].style.display = "none";
    }

    for (var k = 0; k < divC.length; k++) {
        divC[k].style.display = "block";
    }
    for (var k = 0; k < divE.length; k++) {
        divE[k].style.display = "none";
    }
}

function DeleteMember() {
    var divA = document.getElementsByClassName("main_before");
    var divB = document.getElementsByClassName("delete_before_button");
    var divC = document.getElementsByClassName("delete_after");
    var divE = document.getElementsByClassName("edit_before_button");

    for (var i = 0; i < divA.length; i++) {
        divA[i].style.display = "none";
    }

    for (var j = 0; j < divB.length; j++) {
        divB[j].style.display = "none";
    }

    for (var k = 0; k < divC.length; k++) {
        divC[k].style.display = "block";
    }
    for (var k = 0; k < divE.length; k++) {
        divE[k].style.display = "none";
    }
}

function NoDelete() {
    var divA = document.getElementsByClassName("main_before");
    var divB = document.getElementsByClassName("delete_before_button");
    var divC = document.getElementsByClassName("delete_after");

    for (var i = 0; i < divA.length; i++) {
        divA[i].style.display = "block";
    }

    for (var j = 0; j < divB.length; j++) {
        divB[j].style.display = "block";
    }

    for (var k = 0; k < divC.length; k++) {
        divC[k].style.display = "none";
    }
}
