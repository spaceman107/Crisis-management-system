function fetchAndUpdateChart() {
  
    const startMonth = document.getElementById('startMonth').value;
    const startYear = document.getElementById('startYear').value;
    
    const endMonth = document.getElementById('endMonth').value;
    const endYear = document.getElementById('endYear').value;
 
 
    fetch(`transaction_statistics/NewRequests.php?startMonth=${startMonth}&startYear=${startYear}&endMonth=${endMonth}&endYear=${endYear}`)
       .then(response => response.json())
       .then(data => {
         const labelsRequests = data.map(entry => `${entry.year}-${entry.monthname}`);
         const amountsRequests = data.map(entry => entry.amount);

     
    fetch(`transaction_statistics/NewOffers.php?startMonth=${startMonth}&startYear=${startYear}&endMonth=${endMonth}&endYear=${endYear}`)
        .then(response => response.json())
        .then(OfferData => {
          const labelsOffers = OfferData.map(entry => `${entry.year}-${entry.monthname}`);
          const amountsOffers = OfferData.map(entry => entry.amount);

       
    fetch(`transaction_statistics/CompletedOffers.php?startMonth=${startMonth}&startYear=${startYear}&endMonth=${endMonth}&endYear=${endYear}`)
        .then(response => response.json())
        .then(CompletedOfferData => {
            const labelsCompletedOffers = CompletedOfferData.map(entry => `${entry.year}-${entry.monthname}`);
            const amountsCompletedOffers = CompletedOfferData.map(entry => entry.amount);

            
    fetch(`transaction_statistics/CompletedRequest.php?startMonth=${startMonth}&startYear=${startYear}&endMonth=${endMonth}&endYear=${endYear}`)
        .then(response => response.json())
        .then(CompletedRequestData => {
            const labelsCompletedRequest = CompletedRequestData.map(entry => `${entry.year}-${entry.monthname}`);
            const amountsCompletedRequest = CompletedRequestData.map(entry => entry.amount);

          const canvas = document.getElementById('myChart');
          const ctx = canvas.getContext('2d'); 
          const config = {
            type: 'bar',
            data: {
              labels: labelsRequests,
              datasets: [
                {
                  label: 'New Requests',
                  data: amountsRequests,
                  backgroundColor: 'rgba(255, 99, 132, 0.2)',
                  borderColor: 'rgb(255, 99, 132)',
                  borderWidth: 1
                },
                {
                  label: 'New Offers',
                  data: amountsOffers,
                  backgroundColor: 'rgba(120, 90, 60, 0.2)',
                  borderColor: 'rgb(75, 192, 192)',
                  borderWidth: 1
                },
                {
                  label: 'Completed Offers',
                  data: amountsCompletedOffers,
                  backgroundColor: 'rgba(75, 192, 80, 0.2)',
                  borderColor: 'rgb(75, 192, 192)',
                  borderWidth: 1
                },
                {
                  label: 'Completed Requests',
                  data: amountsCompletedRequest,
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
                  borderColor: 'rgb(75, 192, 192)',
                  borderWidth: 1
                }
              ]
            },
            options: {
              scales: {
                y: {
                  beginAtZero: true
                }
                
              }

            },
          };

          var myChart = new Chart(ctx, config); 
        });
    });
  });
    });}
