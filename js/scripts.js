function submit() {
    let paperwork = document.getElementById("paperwork");
    let content = paperwork.value;
    let form = new FormData();
    let req = new XMLHttpRequest();
    req.open("POST", "/upload.php");
    form.append("subgroup", new URL(window.location).searchParams.get("subgroup"));
    form.append("content", content);
    req.send(form);
    req.onload = function() {
        window.location.reload();
    };
}

function submitWithFile() {
    let form = document.getElementById("file-form");
    form.submit();
}

function upload() {
    document.getElementById("file-content").value = "cette file"; // just dont be empty
    document.getElementById("file-subgroup").value = new URL(window.location).searchParams.get("subgroup");
    document.getElementById("file-input").click();
}

function go() {
    let paperwork = document.getElementById("paperwork");
    window.location = "/index.php?subgroup=" + paperwork.value;
}
