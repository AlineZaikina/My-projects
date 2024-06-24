function CatchPay(event)
{
    elem = event.target;
    if (elem.type == "checkbox")
    {
        document.getElementById("DaysOfPay").classList.toggle("hidden");
        if (elem.checked == false)
        {
            document.getElementById("DaysOfPay").value = "";
            GetData();
        } 
    }
}
function Count1Koef()
{
    if (document.getElementById("SecondKoef").value == "") document.getElementById("FirstKoef").value = "";
    else document.getElementById("FirstKoef").value = (1 * 1000 - document.getElementById("SecondKoef").value * 1000) / 1000;
}
function Count2Koef()
{
    if (document.getElementById("FirstKoef").value == "") document.getElementById("SecondKoef").value = "";
    else document.getElementById("SecondKoef").value = (1 * 1000 - document.getElementById("FirstKoef").value * 1000) / 1000;
}
function GetData()
{
    let a2 = document.getElementById("a2").value;
    let b2 = document.getElementById("b2").value;
    let c2 = document.getElementById("c2").value;
    let d2 = document.getElementById("d2").value;
    let k2 = (19 * b2 - 19 * a2 - 24 * d2) / 30;
    let l2 = (19 * c2 - 19 * b2 - 24 * d2) / 30;
    document.getElementById("1companyProfit").innerText = k2.toFixed(5);
    document.getElementById("2companyProfit").innerText = l2.toFixed(5);
    if (Number(b2) != 0 && Number(c2) != 0)
    {
        document.getElementById("1companyRenta").innerText = (k2/b2 * 100).toFixed(2);
        document.getElementById("2companyRenta").innerText = (l2/c2 * 100).toFixed(2);
    }
    let b5 = document.getElementById("FirstKoef").value;
    if (b5 > 0 && b5 < 1)
    {
        document.getElementById("1companyProfit").innerText = (k2 + l2 * b5).toFixed(5);
        document.getElementById("2companyProfit").innerText = (l2 - l2 * b5).toFixed(5);
        if (Number(c2) != 0)
        {
            document.getElementById("1companyRenta").innerText = ((k2 + l2 * b5)/c2 * 100).toFixed(2);
            document.getElementById("2companyRenta").innerText = ((l2 - l2 * b5)/c2 * 100).toFixed(2);
        }
        if (document.querySelector('.form-check-input').checked && document.getElementById("DaysOfPay").value > 0)
        {
            let b14 = document.getElementById("DaysOfPay").value;
            const b15 = 0.16;
            let b16 = b15/365 * b14;
            document.getElementById("1companyProfit").innerText = (k2 + l2 * b5 + a2 * b16).toFixed(5);
            document.getElementById("2companyProfit").innerText = (l2 - l2 * b5 - a2 * b16).toFixed(5);
            if (Number(c2) != 0)
            {
                document.getElementById("1companyRenta").innerText = ((k2 + l2 * b5 + a2 * b16)/c2 * 100).toFixed(2);
                document.getElementById("2companyRenta").innerText = ((l2 - l2 * b5 - a2 * b16)/c2 * 100).toFixed(2);
            }
        }
    }
    for (let i=1;i<3;i++)
    {
        document.getElementById(`tr${i}`).style.backgroundColor = 'white';
        if (Number(document.getElementById(`${i}companyRenta`).textContent) < 15)
        {
            document.getElementById(`tr${i}`).style.backgroundColor = '#f78383';
        }
        if (Number(document.getElementById(`${i}companyRenta`).textContent) >= 15 && Number(document.getElementById(`${i}companyRenta`).textContent) <= 20)
        {
            document.getElementById(`tr${i}`).style.backgroundColor = '#f8fa9d';
        }
        if (Number(document.getElementById(`${i}companyRenta`).textContent) > 20)
        {
            document.getElementById(`tr${i}`).style.backgroundColor = '#b6fa9d';
        }
    }
}
document.addEventListener("click",CatchPay);
document.getElementById("FirstKoef").addEventListener("input",Count2Koef);
document.getElementById("SecondKoef").addEventListener("input",Count1Koef);
document.getElementById("FirstKoef").addEventListener("input",GetData);
document.getElementById("SecondKoef").addEventListener("input",GetData);
document.getElementById("a2").addEventListener("input",GetData);
document.getElementById("b2").addEventListener("input",GetData);
document.getElementById("c2").addEventListener("input",GetData);
document.getElementById("d2").addEventListener("input",GetData);
document.getElementById("DaysOfPay").addEventListener("input",GetData);