let nrZakladuWForm = 0;
przyciskiWidzoczne = false;

document.querySelector(".dodajNowyZakladPrzycisk").addEventListener("click", function () {
    this.style.display = "none";
    tooglePrzyciski(true);
    dodajNowyZakladDoForm();
})

document.querySelector(".dodaj-kolejny-zaklad-przycisk").addEventListener("click", function () {
    dodajNowyZakladDoForm();
})

function dodajNowyZakladDoForm() {
    const x = document.querySelector(".nowy-zaklad-template").cloneNode(true);
    x.style.display = "flex";

    [...x.querySelectorAll('input')].forEach(el => {
        el.name = `${el.name.split('[')[0]}[${nrZakladuWForm}]`;
        if (!el.classList.contains('nowy-zaklad-input-number'))
            el.value = "";
        else
            el.value = 1.0;
    });

    x.querySelector(".usun-zaklad-przycisk").addEventListener("click", function () {
        this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);
        //todo sprwdzić ile zostało w form => tooglePrzyciski();
    })



    x.querySelector(".rodzaj-zaklad-select").addEventListener("change", function () {
        const sel2 = x.querySelector(".wartosc-zaklad-select");
        const val = sel2.options;

        sel2.value = "";
        /*
                const sel = x.querySelector(".rodzaj-zaklad-select");
               const wybrany_zaklad = sel.options[sel.selectedIndex];


                console.log("porownianie do: " + wybrany_zaklad.value);


                for (var i = 0, len = sel2.options.length; i < len; i++) {
                    opt = sel2.options[i];

                    if (opt.value.split("_")[1] != wybrany_zaklad.value) {
                        console.log("hide " + opt.value.split("_")[0] + "+" + opt.value.split("_")[1]);
                        opt.hidden = true;
                    } else {
                        console.log("show " + opt.value.split("_")[0] + "+" + opt.value.split("_")[1]);
                        opt.hidden = false;

                    }
                }
                console.log("______");*/

    })



    x.querySelector(".wartosc-zaklad-select").addEventListener("focus", function () {
        this.select
        const sel = x.querySelector(".rodzaj-zaklad-select");
        const wybrany_zaklad = sel.options[sel.selectedIndex];
    //    const sel2 = x.querySelector(".wartosc-zaklad-select");
        for (var i = 0, len = this.options.length; i < len; i++){
            this.options[i].hidden = this.options[i].value.split("_")[1] != wybrany_zaklad.value;
        }

    })




    document.querySelector(".nowy-zaklad-form").append(x);
    nrZakladuWForm++;
}


document.addEventListener("DOMContentLoaded", function () {

    document.querySelector('.nowy-zaklad-button').addEventListener('click', function () {
        const form = document.querySelector('.nowy-zaklad-form');

        const mecz = form.querySelectorAll(".input-mecz");
        const zaklad_r = form.querySelectorAll(".rodzaj-zaklad-select");
        const zaklad_w = form.querySelectorAll(".wartosc-zaklad-select");
        const kurs = form.querySelectorAll(".nowy-zaklad-input-number");
        const status = form.querySelectorAll(".input-status");

        let tempDataToSent = [];
        for (var i = 0; i < mecz.length; i++) {
            if(zaklad_w[i].value == "")   {
                console.log("nie wybrano wartosci zakładu => nie wysłano zapytania");
                return;
            }
            nowyZaklad = {
                'mecz': mecz[i].value,
                'zaklad_r': zaklad_r[i].value,
                'zaklad_w': zaklad_w[i].value,
                'kurs': kurs[i].value,
                'status': status[i].value,
            }
            console.log(nowyZaklad);
            tempDataToSent[i] = nowyZaklad;

        }
        let dataToSent = {
            'data': tempDataToSent

        }
        console.log(dataToSent);
        dataTo = JSON.stringify(dataToSent);
        console.log(dataTo);
        fetch("/dodajZaklad", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: dataTo
        })
            .then(res => res.json())
            .then(function (res){
                console.log(res);
                createKupon(res);
            })
    });
});

function tooglePrzyciski() {
    if (!przyciskiWidzoczne) {
        document.querySelector(".nowy-zaklad-button").style.display = "block";
        document.querySelector(".dodaj-kolejny-zaklad-przycisk").style.display = "block";
        document.querySelector(".input-stawka").style.display = "block";
        document.querySelector(".label-stawka").style.display = "block";
    }
    else{
        document.querySelector(".dodajNowyZakladPrzycisk").style.display = "block";
        document.querySelector(".nowy-zaklad-button").style.display = "none";
        document.querySelector(".dodaj-kolejny-zaklad-przycisk").style.display = "none";
    }

}



function createKupon(data) {
    console.log("data:");
    console.log(data);
    const metadata = data[0];
    const zaklady = data[1];

    console.log("zaklady");
    console.log(zaklady);

    const template = document.querySelector("#kupon-template");

    const kupon = template.content.children[0].cloneNode(true);
    let header = kupon.querySelector(".kupon-header");
    header.querySelector(".id-kuponu").innerHTML = "#" + zaklady.kupon_id;
    header.querySelector(".data_meczu").innerHTML = zaklady[0].data_meczu;
    header.querySelector("span").innerHTML = zaklady[0].status_kuponu;
    header.querySelector("span").classList.add(zaklady[0].status_kuponu);

    zaklady.forEach(zaklad => {
        createZaklad(zaklad, kupon);
    });
    createBottomTemplate(zaklady[0], kupon )

    console.log("kupon::");
    console.log(kupon);

    document.querySelector(".wszystkieKupony").innerHTML = kupon.outerHTML + document.querySelector(".wszystkieKupony").innerHTML;

}

function createZaklad(zaklad, kupon) {
    const template = document.querySelector("#zaklad-template");
    const zakladDiv = template.content.cloneNode(true);

    zakladDiv.querySelector(".druzyny").innerHTML = zaklad.gospodarz + " - " + zaklad.gość;
    zakladDiv.querySelector(".bet").innerHTML = zaklad.rodzaj_zakladu + ": " + zaklad.wartosc_zakladu;
    zakladDiv.querySelector(".dataMeczu").innerHTML = zaklad.data_meczu;
    zakladDiv.querySelector(".zakladu-kurs").innerHTML = zaklad.kurs;
    kupon.append(zakladDiv);
}

function createBottomTemplate(zaklad, kupon){
    const template = document.querySelector("#kupon-bottom-template");
    const bottom = template.content.cloneNode(true);

    bottom.querySelector(".stawka").innerHTML = "stawka: "+ zaklad.stawka;
    bottom.querySelector(".kurs").innerHTML = zaklad.kurs;
    bottom.querySelector(".pot-wygrana").innerHTML = "$" + zaklad.kurs * zaklad.stawka;
    console.log(zaklad.stawka);
    kupon.append(bottom);
}


