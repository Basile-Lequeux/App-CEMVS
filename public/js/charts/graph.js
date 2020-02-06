function getGraphPerformance(datas){

    // console.log(datas)
    // let labels = [];
    let datas1 = datas[0];
    let datas2 = datas[1];
    

    // for(let i in datas){
    //     datas1.push(datas[i][0]);
    //     datas2.push(datas[i][1]);
    //     labels.push(datas[i][2]);
    // }

    // console.log(datas1)
    // console.log(datas2)
    var ctx = document.getElementById("myChart").getContext("2d");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
        labels: ['Performances Compétitions'],
        datasets: [
            {
            label: "Vos Performances",
            backgroundColor: "#3e95cd",
            data: [datas1]
            }, {
            label: "Moyenne Tireurs",
            backgroundColor: "#8e5ea2",
            data: [datas2]
            }
        ]
        },
        options: {
        title: {
            display: true,
            text: 'Résultats aux compétitions'
        },
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                    suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                    // OR //
                    beginAtZero: true   // minimum value will be 0.
                }
            }]
        }
    
        }
    }); 
   

}
function getGraphEngagement(datas){
    // console.log(datas)
    var ctx = document.getElementById("engagement").getContext("2d");
    var myChart =  new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ["Participation", "Total"],
          datasets: [{
            label: "Engagements",
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
            data: [datas[0][0],datas[0][1]]
          }]
        },
        options: {
          title: {
            display: true,
            text: 'Engagement en fonction du nombre de compétitions pour votre catégorie'
          },
        }
    });
}
    
function getGraphAssiduite(datas){
    // console.log(datas)
    var ctx = document.getElementById("pie-chart").getContext("2d");
    var myChart =  new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ["Participation", "Total"],
          datasets: [{
            label: "Participation aux Entrainements",
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
            data: [datas[0][0],datas[0][1]]
          }]
        },
        options: {
          title: {
            display: true,
            text: 'Assiduité aux Entrainements en fonction de la participation et du nombre d\'entrainement'
          },
        }
    });
    
}