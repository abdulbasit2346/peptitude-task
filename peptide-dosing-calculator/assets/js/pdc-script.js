document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("pdc-form");
    const results = document.getElementById("pdc-results");
    const errorBox = document.getElementById("pdc-error");
    const warningBox = document.getElementById("pdc-warning");
    const bar = document.getElementById("pdc-bar");

    function getValue(selectId, customId) {
        const select = document.getElementById(selectId);
        const custom = document.getElementById(customId);

        if (select.value === "custom") {
            custom.hidden = false;
            return parseFloat(custom.value);
        } else {
            custom.hidden = true;
            return parseFloat(select.value);
        }
    }

    function calculate() {

        let vialMg = getValue("pdc-vial", "pdc-vial-custom");
        let waterMl = getValue("pdc-water", "pdc-water-custom");
        let doseMcg = getValue("pdc-dose", "pdc-dose-custom");
        let syringeMax = parseFloat(document.getElementById("pdc-syringe").value);

        if (!vialMg || !waterMl || !doseMcg || vialMg <= 0 || waterMl <= 0 || doseMcg <= 0 || vialMg > 20 || waterMl > 6 || doseMcg > 2000) {
            errorBox.innerText = "Please enter valid positive values.";
            results.hidden = true;
            return;
        }

        errorBox.innerText = "";

        let concentration = (vialMg * 1000) / waterMl;
        let volume = doseMcg / concentration;
        let units = Math.round(volume * 100);
        let dosesPerVial = Math.floor((vialMg * 1000) / doseMcg);

        document.getElementById("pdc-concentration").innerText = concentration.toFixed(2);
        document.getElementById("pdc-volume").innerText = volume.toFixed(3);
        document.getElementById("pdc-units").innerText = units;
        document.getElementById("pdc-doses").innerText = dosesPerVial;

        let percentage = (units / syringeMax) * 100;
        bar.style.width = percentage + "%";

        if (percentage <= 60) {
            bar.style.background = "green";
        } else if (percentage <= 85) {
            bar.style.background = "orange";
        } else {
            bar.style.background = "red";
        }

        if (units > syringeMax) {
            warningBox.innerText = "Warning: Required units exceed syringe capacity!";
        } else {
            warningBox.innerText = "";
        }

        results.hidden = false;
    }

    form.addEventListener("input", calculate);
});
