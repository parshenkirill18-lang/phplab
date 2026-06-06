function press(value) {
    document.getElementById("display").value += value;
}

function clearDisplay() {
    document.getElementById("display").value = "";
}

function calculate() {
    let expression = document.getElementById("display").value;

    fetch("calc.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "expression=" + encodeURIComponent(expression)
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById("display").value = data;
    });
}