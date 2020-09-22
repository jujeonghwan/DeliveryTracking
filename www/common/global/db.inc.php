<?php

// DB
$GLOVAL_DB["host"]  =   "localhost";
$GLOVAL_DB["user"]  =   "deliverytracking";
$GLOVAL_DB["pass"]  =   "#deliverytracking2018";
$GLOVAL_DB["name"]  =   "deliverytracking";

// MySQL DB 서버에 접속후 데이터베이스를 선택
function db_connect() {
    global $mysql_connect;
    global $GLOVAL_DB;

    $mysql_connect = mysql_connect ($GLOVAL_DB["host"], $GLOVAL_DB["user"], $GLOVAL_DB["pass"]) or die ("DB 서버에 접속할 수 없습니다.");
    mysql_select_db ($GLOVAL_DB["name"], $mysql_connect) or die ("데이터베이스를 선택할 수 없습니다.");

    // character_set
    mysql_query ("set names utf8");
    
    return $mysql_connect;
}

// 데이터베이스에 질의를 전송
function db_query($pQuery, $pConnect = "") {
    global $mysql_connect;

    $temp_connect = ($pConnect == "") ? $mysql_connect : $pConnect;
    
    $result = mysql_query ($pQuery, $temp_connect) or mysql_error();

    return $result;
}

// 결과로부터 열 개수를 반환
function db_num_rows($pResult) {
    return mysql_num_rows($pResult);
}

// 최근 INSERT 작업으로부터 생성된 identifier 값을 반환
function db_insert_id() {
    return mysql_insert_id();
}

// 결과를 필드이름 색인 또는 숫자 색인으로 된 배열로 반환
function db_fetch_array($pResult) {
    return mysql_fetch_array($pResult);
}

// result에 대한 메모리(memory)에 있는 내용을 모두 제거한다.
function db_free_result($pResult) {
    mysql_free_result($pResult);
}

// MySQL 접속을 닫음
function db_close() {
    global $mysql_connect;

    if ($mysql_connect) {
        mysql_close ($mysql_connect);
        $mysql_connect = "";
    }
}


// DB 구조및 관련 배열 변수

/* 공통 배열 항목 ABC순 */
// 진행상태
$db_common_dealstate_array = array (
    "진행"    =>  "1",
    "중단"    =>  "2"
);
$color_common_dealstate_array = array (
    "1" =>  "blue",
    "2" =>  "red"
);

// 수집상태
$db_common_gatherstate_array = array (
    "수집대기"  =>  "1",
    "수집완료"  =>  "2"
);
$color_common_gatherstate_array = array (
    "1" =>  "red",
    "2" =>  "blue"
);

// 처리상태
$db_common_processstate_array = array (
    "미처리"    =>  "1",
    "처리완료"  =>  "2"
);
$color_common_processstate_array = array (
    "1" =>  "red",
    "2" =>  "blue"
);

// 사용상태
$db_common_usestate_array = array (
    "사용"    =>  "1",
    "중지"    =>  "2"
);
$color_common_usestate_array = array (
    "1" =>  "blue",
    "2" =>  "red"
);

// 공개여부
$db_common_viewtype_array = array (
    "공개"    =>  "1",
    "비공개"   =>  "2"
);
$color_common_viewtype_array = array (
    "1" =>  "blue",
    "2" =>  "red"
);

// 예아니오
$db_common_yesnotype_array = array (
    "예"     =>  "1",
    "아니오" =>  "2"
);
$color_common_yesnotype_array = array (
    "1" =>  "blue",
    "2" =>  "red"
);

/* 배송조회
CREATE TABLE deliverytracking_tb (
  dt_id int(11) NOT NULL AUTO_INCREMENT COMMENT '배송조회번호',
  dt_deliverytype varchar(30) NOT NULL DEFAULT '' COMMENT '택배사구분',
  dt_keyword varchar(30) NOT NULL DEFAULT '' COMMENT '검색어',
  dt_invoice varchar(30) NOT NULL DEFAULT '' COMMENT '운송장번호',
  dt_deliveryprogress varchar(30) NOT NULL DEFAULT '' COMMENT '배송진행상태',
  dt_result text NULL COMMENT '조회결과',
  dt_resulttext text NULL COMMENT '조회결과문자',
  dt_remark varchar(100) varchar(100) NOT NULL DEFAULT '' COMMENT '비고',
  dt_userid varchar(50) NOT NULL DEFAULT '' COMMENT '사용자ID',
  dt_ipaddress varchar(20) NOT NULL DEFAULT '' COMMENT 'IP주소',
  dt_regtime varchar(14) NOT NULL DEFAULT '' COMMENT '등록일시',
  dt_lastvisittime varchar(14) NOT NULL DEFAULT '' COMMENT '최종방문일시',
  dt_referer varchar(500) NOT NULL DEFAULT '' COMMENT '링크주소',
  PRIMARY KEY (dt_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='배송조회';
ALTER TABLE deliverytracking_tb ADD INDEX (dt_deliverytype);
ALTER TABLE deliverytracking_tb ADD INDEX (dt_keyword);
ALTER TABLE deliverytracking_tb ADD INDEX (dt_invoice);
ALTER TABLE deliverytracking_tb ADD INDEX (dt_deliveryprogress);
ALTER TABLE deliverytracking_tb ADD INDEX (dt_userid);
ALTER TABLE deliverytracking_tb ADD INDEX (dt_ipaddress);
ALTER TABLE deliverytracking_tb ADD INDEX (dt_regtime);
ALTER TABLE deliverytracking_tb ADD INDEX (dt_lastvisittime);
*/
// 배송진행상태 (배달완료쪽이 먼저 나오게 처리)


////////////////////////////////////////////////////////////////////////////////
/*
// 쿠팡 최종 배송상태 이미지 공통부분 (최종상태)
$COUPANG_COMMON_COMPLATE_TEXT = "iVBORw0KGgoAAAANSUhEUgAAAGQAAAAcCAYAAACXkxr4AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAA";
*/
////////////////////////////////////////////////////////////////////////////////

// 쿠팡 배송상태 이미지 공통부분 (기타)
// $COUPANG_COMMON_TEXT_OLD = "iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAA";

// $COUPANG_COMMON_TEXT = "SURBVGhD7Z";
/*
// 배송출발
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE2SURBVGhD7ZkBDoMgDEU9HgfiON7Fq3gSu1ZlViwobG4L+y9pyhCK+X81MXYAAAAAAADcxzRNtA6reUcNAMDPMvaOXD+izVOIQH6gWSCikXrnaZizI9aN9HWLM4GJq3lOMrRDztvqx+fR4KnjiXjcLK8YsojNhsx70qYFNnPS62FIpSEyH4QNQludsqzbd0PcNXrffv0a2pB1zrqnJjgKkDckrA8iym891tdqiM9Dhzw7ZDNJCxSjDYnR/+izCGcEU3fxYUO++m6RNuTYITUCx+QMBEyJIbVIDU5mWOZkjeeb4dwuR7GuGTJ4vWeNQrFE+JJu+dQj6+dYOiVtiMxZQubmOZmBDrnAHYbENXKUdk7znBkilDyypAYnO1zPp+3rZzsk81IJAAANgA9RAAAAAAD/R9c9AEPLfGASP0o1AAAAAElFTkSuQmCC
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE3SURBVGhD7ZoBDoMgDEU9HgfiON7Fq3gSu1ZlViwoGDNH/kuaMsRi/l/JTNYBAFphmiZahwAAAAAAAPwLY+/I9SN+yqYQgfxAs0BEI/XO0zBnR6wb6esWZwITV/OcZGiH7LfVj/ejwVPHE/G4We4YsojNhsz3pE0LbOak198xpImXyFpDZD4IG4S2OmVZt++GuGv0ffv1a2hD1jnrmZrgKEDekLA+iCif9VhfqyHeD0fWt0M2k7RAMdqQGP2NPouwRzB1Fy8y5PFjMW3IsUNqBI7JGQiYEkNqkRqczLDMyRrPD8O5XY5iXTNk8PqeNQrFEuFLuuUNR9ZPWDolbYjMWULm5jmZgQ65wBOGxDVylHZO85wZIpQcWVKDkx2u59329bMdknmpBAAAAEAl+IsOAAAA8Eu67gM+ZXhnHQM+3wAAAABJRU5ErkJggg==
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE+SURBVGhD7ZcBjoQgDEU9HgfiON7Fq3gSu61KLLXiwGZmVva/pAERW/M/NXEAAAAAAAAAAAC+xjwGCuNM+yWwiEBxolUgopnGEGlax0CsG+n7HncCE2eLPMjUD6l35Lf1aIo08IKdd8tvDNnEZkPWZ65NSxzmXO//q4Ysy/KZuq2GyHoSNgntdcq2L+8G2zX6uXz/HtqQfc17py44C1A2JO1PIsq1nut7Ldh6LR3ysdP8DrQAeYccJmmBLNoQiz7Rd5FqJFOzqDTk0Vwbcu6QFoEtJQMBU2NIK5KDBzc8c4rG88vw2C9nsV4zZIr6mT0qxRLha7rlX3yyPLZOuTZE1jwhS+s8uIEOeYF3GGJzlKjtnO65M0So+WRJDh78CCNXy/MXO6TwUwkAAF/g0X/aAGTgNINHgoMLAOiCYfgB96N8YK2Py2sAAAAASUVORK5CYII=
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAEwSURBVGhD7ZkNDoMgDIU9HgfiONzFq3gSu1ZhFqw4XPYTfF/SlCEW896KWTYAAAAA4LvM80xxCAAA4AdMwZELE85iC3lJiUB+pEUgoomC8zQu2RHrll23OBOYuJrnJEM7ZL+tfrkfjZ4GnijH3fKOIavYbMhyz7Fpic2c4/Uw5KIhMp+ETUJbnbKuy7uh7Bp9X74+hjYkzlnP1AV7AeqGpPVJRPmsx/raFcr90CHPDtlM0gKVaENK9Df6LNIeydQsYIjdIVcELqkZCJgWQ64iNTiZYZlTNZ4fhnO/7MV6zZDR63tiNIolwrd0yy2OLIu1U44NkTlLyNo8JzPQIS/wCUPKGjVu2wlHnBkitBxZUoOTHS7wbnn9aodUflQC0Df4AwgAAMC/gHcSAACAvhmGBz+kd9YfgP7yAAAAAElFTkSuQmCC
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE7SURBVGhD7ZcBDoMgDEU9HgfiON7Fq3gSu1YlllpwmG3Z2H9JU4ZYzP+WbQMAAICXsSwL7UMAAADgZ8H3Gfgs8xgojDPeuhIiUJxoFYhopjFEmtYciHUjfV2wLXwlMHG1yEmGfsh+R327H02RBp6w425pNUSzic2GrPf4azSHOeX1MOSmITKfhE1Ce52yrcu7wXaNvi9fv4c2ZJ/znqkLzgLUDUnrk4jyWY/1tTvY/Wod0uUvIC1A3iGHSVogizbEot/oq0h7JFOzKBjSJWVDzh1yR2BLzUDAtBhyF6nByQ3PnKrx/DCcv5KXHKFnsZ4zZIr6nj0axRLhW7rlL44sj61TyobInCdkbZ6TGz11yNt4hyG2Ro3WzumeK0OEliNLanDyI4y8W16/2iGVP5UAAAAAAAAAAMAPMgwPIkV8YLEJHM8AAAAASUVORK5CYII=

// 캠프도착
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE6SURBVGhD7ZoNDoMgDIU9HgfiONzFq3gSuxYBEUFRtxnxfUmDIH/jtWXJ1gEA3sA4juQeAQAAAAAAAA9iMEq+y0emqSeiXisyA5G819wgfQVuILXon9o0jp8D6zVmU9yZyxV2HV7YVS28KeqStqZhGUgrQ3yeRUHOUDsHr0ZG5YSb9tK8ILkD8B7b67ktd5iryOHDKnn7GVFfHyE2Oly6kvpehPxSkNlRlunPCsKF2JH5HscUDbMYwp4gqQBbh35EkMkxeD8ywN1XfmzzERI8MfMhi5d65KUli/sLMgcXeYvW9mLEQvs2mbN5Qe5AxCmlNhARX+KppR5/hRpBtvbymgjxKcpVA3HKqklX3kKKybzLWY3oWymrud9GagQ5wzcP6lV3yL9S1hVwqQMAAAAAAPBT8Kc8AO6h6z6fOthiPwW9LgAAAABJRU5ErkJggg==
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFMSURBVGhD7ZkBroMgDIY9HgfiNs+7eJR5EvtaRl1lxeHb8pbA/yUNUtGy/lBMNgEAAOiabdsoXwIAAAAANLDOQb4ejEVaiGiJgeaVSO5HdshYgR0UDuNLuz/H1zvPMR4WeDC3T6Q4HDh3Ezwpmgpf17AMFMNMnM+qIH9B3lFLvIWj0Rx84WQO3QviJUATt8RjMsSn6HPql2/0lKwsZhpkaBXE4iV/qB2SdkcuV9J/tUNEMOs/S9ZVQR4L5Vj+UgxuxLw5dYMkTM+O7EqC/Ny2qiBlks+SfkWQ+8LgpEvQfF5p/O53yL4SnR9ZPdTNKq2ZHS/IO7jxzcRWMax46pN3DlWy/osru2Vo7CFeWrni36FFkLO5DLNDtETl7o4tWS3lSm0vMc49z1pEH6pktQjybQYTxF+5YhAEvAR/GAEAAAAAAPA18DkOwGeZpl/umdoS1j2tHAAAAABJRU5ErkJggg==
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE1SURBVGhD7ZWNEYMgDIUdj4EYh11cxUlME5QfERTba7XwvrscBYFQXhIGAAAAAAAAAAAAPJXJKOImMk0jEY1akZmI5LvmAZkr8ACpzfzUlnX827P3EUzxZG53WD/seO1a+FA0JGNNwzKQVob4PouCvEPtHuyNjMoJt5yleUFyF+AidtRhLHeZu8zhyypF+zuidp8hNjvWciX9swz5piAhULblzwrCjdiV/f6OJRuCGMKZIKkAR5d+RZAlMPg8smB9r9za5jPER2LmTxYf9ShKSxbPF2QPbvIW+XZixEK7MdmzeUHuQMQplTYQET/iqaUR/wk1ghydpZsMcSVq7XriklVTrpz5EpP5lrMa0bsqWTWC3E1nguQjVwyCAAAaYJ7nn5ePO3w+Alx2oNsgAAAAAMAVhuEF1HjcWx2VCZkAAAAASUVORK5CYII=

// 캠프상차
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFbSURBVGhD7ZiLDYQgDIYdj4EYx11cxUnstRQUK/jKXeLJ/yWN8rBof1oSOwAAeAnTNFG8BQD8HchgcBpsFgBAa4y9k7qXmaeBiAbvqB+JZNxzh8wVuIPcar41fY7vV7BDcjwQmwHp69h5bK4I65ixko9XwzKQdz1xPKuC3OWMIGF9vsitNXn29YJwuKl32w+XscEvfSVBNplzEKzgL4odu5Ahe+ju1HIl7aMMuSJICm7pGbmI2TWaFkSzYRFDOBLEBqc6L5w56jtlZJoXBDFBT4g/+057Ar6CuWQVglI91LOg1GwOuMk6QddU3zVBVERHzryb3QTgy5QESYJL4OdDPp49TQmSH+LW8gy5SvqdoCXI+LaHfBTArifvFgRqSxAtI7E5k5estHvPWB7UIIbJBKGUIXv8QpDH/n86I8hdnizIY/lVyUoUS9YFMYSmBAEAAAAAAAAA0Apd9wHP1jphKKq/GAAAAABJRU5ErkJggg==
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFnSURBVGhD7ZkBroMgDIY9HgfiOJ5lXmUnsWsLstrBNOYtj8j/JUQoUlx/Ci5OAAAAfs66rpSrAAAAAACd85yDvLmYEmkhoiUGmp9E0h/ZIPcKbKCwu9+XNI7rO9ghBe7ITUVsEzvPzR06j+ur+bg1LAPFMBPHsynIVc4IovPzRaq+yNjbC8Lhpjl8/nDpW+Lb5gXZxsXH+3+BBjeLmU07NBNdvxfEMnyGpNWZtitpH2WICGbtZ4IrvmxAdQxfpPg5hhZEV68RQzgSxAfXtzc0sNl3yazs75uItWeyAt5SmLJlVYLSPNRNUFqlBNyIIW0hzZl8twRJ41hg92zDZMh/URNkE1wCXxZMPnuGEsQe4r7YDLlK2oKcby8G55K8Zfn59NnEOJYgaRvJzYLdsrbVe6bYoKoYLvhCLUO+AUEYf4ZcoSVIy96iZ0H+/NNAD1vWEUNlCADdgy+UAAAAQAfgQAYAgB8wTS8omzY+jVqhgwAAAABJRU5ErkJggg==

// 센터도착
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAE8SURBVGhD7ZaNDcIgEEaZzjAQ28gsMopOwnlXoAUCai0abb+XXGgv/BReoVUAAAAAAAAAAAD4dZzRZG9E8VbdrCbjiFIZ04oTpLmQyyVCW65NVhvi6nN94Xo+VfWX0NyQywLvvQxMmgeOqQl/MaSqXELaxMt9sEpIZ1F6Quo+eoT2LXFRuOsL2RVhIcKkZfEkJfFtITmtcY4jJB1D2WTTIjaFSN05RIAjU9xvExLESl/lrp2ExHHW9PdX8DnAixkm7swy0YdCOBFvC0bskPA8vOhh8El+arv7HZLLiCn+lpRH1SghXLQj6yvJyD/0KSfPcJgjq8VIITnSX+vPClRs++3l0JZ1jBEiu5SLdnReht1RC3mHeofkH+FnkUvvcagj6xNCRnMwIe03d4oXFwFCAAAAAAAAAACA1Sh1B2DNNf9uhnRWAAAAAElFTkSuQmCC
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFASURBVGhD7ZhbEsIgDEVZHgtiOd0LW3EljQmQmlaoVvFDuGcmE8ggj1weqgMAAAB6sK4rlSIAAAAARiAGT8uNtgf+tngKkUh9CTsOkGcnRWvShlvT4gNJkWMb0ge7qnkelP0TaRzutFQTFAO5Q2xYLgnSSMqZIK3EW/Ln68LJHKYRRBOhAkhITOviU0Pml4JYasmfRxC9hsxiVYiqINJ2MxEgUtjVrwly/C2kG8S5/alNgpRx7JyGgu8BTmZeeAyPhZ4KwoFS3dHjhOT5cNLz4El8HX/4E2LFKCF+S/JD21sQdnUzfakYVjyNyRymubJq9BTEIv1pwvG3zQnffu11fmE5rgnSQk4pu7o1NsNwHAX5hOMJsY/wK7Oit5jqyvqFIL2ZTJD6zk32ZhL+VRC8ZQAAAK6CtwMAAAAAYFycuwOLlT2GO31kYwAAAABJRU5ErkJggg==

// 센터상차
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFsSURBVGhD7ZoBrsIgDIY5neFA3MbdZUd5nmR9bWknQ8ZzupcY+b+EsCF0WT+7YWIAAAAAPo1lWcgOAQAAAACAMqdI043WXdJtipRmIu9tOPAARe7k8N7yWp5NU0zE09f5vvOiOVHkSTpoyFjg4Ha6Qa9TfdaK8bUcErKXxIYQ5xkhxCsTd3JYN1k7jJCcyCxEBMiQtDOFzIljxolnFLFQIW305rkrk9OtEJm7NhFQfrMfhXhyH2KJEFtXjgu+xk6VIYTkx0SuDvkWe2K6QqpEOVIh18tWiM43SbmC7tfoVYhct5bbE/gVlDJsSB8tcrOvCikfWTl+lVSdY5uAHSFZYqTI8jbvmBEqZI8zhPxFS4hXgb7EVShLsXfPUELe2/Z60vaFSBzuGmuK2CagvJ4gVauCRhbyCnsVojIaVdWqkB4QchAIORH9ncD33GxPJq33Dvm5XrYxD8R1hhICAAAAfAr4wwMAAADw34TwC4wAl+7QG+PkAAAAAElFTkSuQmCC
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAeCAYAAADaW7vzAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAFkSURBVGhD7ZZrEoMgDIQ5HgfiON7Fq/QkpnnZRhSrtX8q+80wSBpgzLrQBAAAAAAAAAAArBhLpuFB5MP0GDKVkWjuPZw4QJk7eYxNcjibhlxIHjm2gMZCmTfwoSKxxBN9uED3qX7bWuO2nBKkVcSLghDPLNzJY91kbjeCWCHtKxcBJCTtl4LounngjLAWHLKNvjx3sTi7DpHcVxMB4pe9FmQurqwVC6qC+Ly4hzDP8aHShSB2TNhxNZZ3YXYFqQo1Ex0yTZPmaL6LZL+/99hziOxbixsFvKUwUQwP8V1iL3tVEB0HMTSBsRzbsyWIzWM3sXiLO6YHh7T4hSCfiIK8HOUukMLbeiyK3z1dCXL1b68VrS2IrMPdslXCmmPX94m4VnK7FuQbWg5RMariC9EhR4AgJzkrSCveohZkPuZuiR4L/M6b7WDR9u6QI0fWJ7pySC/c2lUAgN7BEQcAAAAA8J+k9ATN9JmiIIB4NAAAAABJRU5ErkJggg==
*/

// http://b2c.goodsflow.com/small/Coupang/Resource/image/logistics/tc_coupangls.png
// http://b2c.goodsflow.com/small/Coupang/Resource/image/logistics/tc_coupangls.png

$db_dt_deliveryprogress_array = array (
    
    // 쿠팡로켓배송 우선 처리    
    "tc_coupangls.png" => "상세보기확인",

    // 롯데택배
    "상세내역 참고" => "상세내역참고",

    // 데이터 없음
    "검색내역이 없습니다." => "조회불가",
    "검색된 결과가 없습니다." => "조회불가",
    "배송 정보를 읽을 수 없습니다." => "조회불가",
    "입력값(배송번호 등)을 확인해 주십시오." => "조회불가",
    "검색하신 운송장번호로 운송된 내역이 없습니다." => "조회불가",
    "정보가 아직 입력되지 않았거나 처리 중입니다" => "조회불가",
    "해당 번호에 대한 배송정보가 없습니다" => "조회불가",
    "운송장 번호에 대한 자료가 없습니다" => "조회불가",
    "운송 작업 내역을 찾을 수 없습니다" => "조회불가",
    "운송장번호가 일치하지 않습니다" => "조회불가",
    "조회된 데이터가 없습니다" => "조회불가",
    "검색된 운송장이 없습니다" => "조회불가",
    "보류 중" => "조회불가",
    "\uBCF4\uB958 \uC911" => "조회불가",
    "이 배송 조회 번호를 찾을 수 없습니다." => "조회불가",
    "번호를 확인하거나 발송인에게 문의하십시오" => "조회불가",
    "Not Found" => "조회불가",
    "일치하는 운송장 번호가 없습니다." => "조회불가",
    "운송장번호를 정확하게 입력해 주십시오" => "조회불가",
    "배송자료를 조회할 수 없습니다!" => "조회불가",
    "우편물번호를 다시 확인하세요." => "조회불가",
    "입력하신 번호는 유효한 조회 번호가 아닙니다" => "조회불가",
    "요청된 발송물 세부사항을 찾을 수 없습니다." => "조회불가",
    "정보를 확인하고 나중에 다시 시도하십시오." => "조회불가",
    "일치하는 결과가 없습니다. 다시 시도해주세요." => "조회불가",
    "조회결과가 없습니다." => "조회불가",
    "화물추적 내역이 없습니다." => "조회불가",
    "아직 접수되지 않는 상품입니다." => "조회불가",                          // CU편의점PICK-UP

    // 수취 고객
    "배달 완료하였습니다" => "배달완료",
    "배달완료 되었습니다" => "배달완료",
    "배달완료" => "배달완료",
    "배달 완료" => "배달완료",
    "배송완료 되었습니다" => "배송완료",
    "배송완료" => "배송완료",  
    "배송 완료" => "배송완료", 
    "Track End" => "배송완료",
    "수령인에게 인도가 완료되었습니다." => "배송완료",
    "수취인에게 배달되었습니다" => "배송완료",
    "고객 수취" => "배송완료",
    "Delivered" => "배송완료",
    
    // 현지택배 전달완료
    "점포 입고" => "편의점전달완료",
    "CJ대한통운 택배운송" => "CJ대한통운전달완료",
    "우체국에서 배달" => "우체국전달완료",

    // 현지택배 전달완료
    "특송장 반출" => "현지택배전달준비",
    
    // 통관    
    "통관이 완료 되었습니다." => "통관완료",
    "통관 완료" => "통관완료",

    "통관중" => "세관통관",
    "정식통관 진행 중입니다." => "세관통관",
    "세관 통관이 진행되고 있습니다" => "세관통관",

    "특송장 반입" => "특송장반입",
     
    // 배송기사
    "배송을 시작했습니다" => "배송시작",
    "직원이 배달하기 위해 출발했습니다." => "배송출발", 
    "배송출발 하였습니다" => "배송출발", 
    "배달할 예정입니다" => "배달예정", 
    "배달 준비중 입니다" => "배달준비중",
    "배달준비" => "배달준비",
    
    // 도착터미널~배송지점
    "배송출고" => "배송출고", 
    "배송입고" => "배송입고",
    "대리점에 도착했습니다" => "대리점도착",
    "배달지에 도착하였습니다" => "배달지도착", 
    "상품이 도착하였습니다" => "배달지도착", 
    "Arrive at" => "배달지도착",    
    "편의점센터 출고" => "배달지도착",
     
    // 출발터미널~도착터미널
    "도착" => "도착", 
    "상품이 이동중입니다" => "상품이동중",
    "이동중 입니다" => "상품이동중",
    "발송" => "발송", 
    "Despatched from" => "발송",
    "Dispatch to provincial office" => "배달지지점발송",   
    "Departed Shipping Partner Facility" => "발송지배송사출발", 

    "터미널에 도착했습니다" => "터미널도착",
    "간선하차" => "터미널이동중",
    "간선상차" => "터미널이동중",
    "터미널에서 출발했습니다" => "터미널출발",
    "터미널출고" => "터미널출고",    
    "터미널입고" => "터미널입고",
    "편의점센터 입고" => "편의점센터입고",

    // 국제우편 도착국가 물류센터
    "운송 중" => "운송중",
    "교환국 도착" => "교환국도착",
    "해외창고출고" => "배송국가출고",

    "Turn-over item to next office" => "택배사물품인도",
    "Receive at country of destination" => "배송국가도착",
    
    // 발송국가 물류센터    
    "Handled by airline,flight No" => "항공운송중",
    "Internationg Mail Center" => "국제우편처리중",    
    "The post office of electronic information has been received" => "배송국가우체국접수",

    "Dispatch to country of destination" => "국제발송완료",
    "Prepare dispatch to destination country" => "국제발송준비",
    "Receive item at origin country gateway" => "발송교환국에 도착",

    // 발송고객~집하
    "발송준비" => "발송준비",    
    "해외창고입고" => "배송국가입고",
    "sorting center" => "배송국가입고",
    "입고되었습니다" => "집하입고",
    "집하입고" => "집하입고",
    "집하" => "집하입고",
    "Arrived Shipping Partner Facility" => "집하입고",

    "집화예정입니다" => "집화예정",
    "상품을 인수하였습니다" => "상품인수", 
    "상품을 인수받았습니다" => "상품인수", 
    "픽업 완료" => "상품인수",  
    "Picked Up by Shipping Partner" => "상품인수",  

    "Acceptance" => "물품접수",
    "Accepted at" => "물품접수",
    "물품을 접수했습니다" => "물품접수",    
    "직원이 발송물을 접수하였습니다" => "물품접수",

    "미수거" => "미수거",

    "운송장출력" => "운송장출력",

    "운송장을 발행하였습니다" => "운송장접수",
    "조회된 상품상태 데이터가 없습니다" => "운송장접수",
    "The item information was created by the seller" => "운송장접수",
    "UPS 준비 완료" => "운송장접수",
    "Posting of item" => "운송장접수",
    "접수" => "운송장접수",
    "예약" => "예약"
);
$color_dt_deliveryprogress_array = array (
    "-" => "red",
    "조회불가" => "red",

    "배달완료" => "blue",
    "배송완료" => "blue",
    "세관통관" => "blue"
);


/* 링크프라이스앱광고
CREATE TABLE linkpriceapp_tb (
  lpa_id int(11) NOT NULL AUTO_INCREMENT COMMENT '링크프라이스앱광고번호',
  lpa_app_id varchar(30) NOT NULL DEFAULT '' COMMENT '앱아이디',
  lpa_merchant_id varchar(30) NOT NULL DEFAULT '' COMMENT '머천트아이디',
  lpa_ad_name varchar(50) NOT NULL DEFAULT '' COMMENT '캠페인명',
  lpa_os_type varchar(1) NOT NULL DEFAULT '' COMMENT 'OS구분',
  lpa_banner_url varchar(200) NOT NULL DEFAULT '' COMMENT '배너URL',
  lpa_price int(11) NOT NULL DEFAULT '0' COMMENT '커미션',
  lpa_begin_dt varchar(8) NOT NULL DEFAULT '' COMMENT '운영시작일',
  lpa_end_dt varchar(8) NOT NULL DEFAULT '' COMMENT '운영종료일',
  lpa_daily_cap int(11) NOT NULL DEFAULT '0' COMMENT '제한일자',
  lpa_click_url varchar(200) NOT NULL DEFAULT '' COMMENT '링크URL',
  lpa_ad_desc text NULL COMMENT '소개자료',
  PRIMARY KEY (lpa_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='링크프라이스앱광고';
ALTER TABLE linkpriceapp_tb ADD INDEX (lpa_app_id);
ALTER TABLE linkpriceapp_tb ADD INDEX (lpa_merchant_id);
ALTER TABLE linkpriceapp_tb ADD INDEX (lpa_ad_name);
ALTER TABLE linkpriceapp_tb ADD INDEX (lpa_os_type);
ALTER TABLE linkpriceapp_tb ADD INDEX (lpa_begin_dt);
ALTER TABLE linkpriceapp_tb ADD INDEX (lpa_end_dt);
*/
// OS구분
$db_lpa_os_type_array = array (
    "iOS"       =>  "I",
    "Android"   =>  "A"    
);
$color_lpa_os_type_array = array (
    "I" =>  "blue",
    "A" =>  "red"    
);

/* 다중검색
CREATE TABLE multisearch_tb (
  ms_id int(11) NOT NULL AUTO_INCREMENT COMMENT '다중검색번호',
  ms_deliverytype varchar(30) NOT NULL DEFAULT '' COMMENT '택배사구분',
  ms_keyword varchar(30) NOT NULL DEFAULT '' COMMENT '검색어',
  ms_remark varchar(100) NOT NULL DEFAULT '' COMMENT '비고',
  ms_userid varchar(50) NOT NULL DEFAULT '' COMMENT '사용자ID',
  ms_processstate tinyint(4) NOT NULL DEFAULT '1' COMMENT '처리상태',
  ms_regtime varchar(14) NOT NULL DEFAULT '' COMMENT '등록일시',
  PRIMARY KEY (ms_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='다중검색';
ALTER TABLE multisearch_tb ADD INDEX (ms_deliverytype);
ALTER TABLE multisearch_tb ADD INDEX (ms_keyword);
ALTER TABLE multisearch_tb ADD INDEX (ms_userid);
ALTER TABLE multisearch_tb ADD INDEX (ms_processstate);
ALTER TABLE multisearch_tb ADD INDEX (ms_regtime);
*/
// 처리상태
$db_ms_processstate_array = $db_common_processstate_array;
$color_ms_processstate_array = $color_common_processstate_array;

?>
