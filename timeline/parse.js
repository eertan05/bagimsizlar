const fs = require('fs');
const Papa = require('papaparse');

// Define parsedData globally
let parsedData;

// Function to parse the CSV file and store the result in parsedData
function parseCSVFile(filePath) {
  fs.readFile(filePath, 'utf8', (err, data) => {
    if (err) {
      console.error('Error reading CSV file:', err);
      return;
    }

    Papa.parse(data, {
      header: true,
      dynamicTyping: true,
      complete: function (result) {
        parsedData = result.data;
        // You can now use parsedData here, or it's also available globally
        // for use in other functions.
        processData(parsedData);
      },
      error: function (error) {
        console.error('CSV parsing error: ', error.message);
      },
    });
  });
}

// Function to process the parsed data
function processData(data) {
  // Do something with the parsed data
  console.log(data);
}

// Example usage
const filePath = 'timelineTest2.csv';
parseCSVFile(filePath);

// Now you can access parsedData here or in other functions
console.log(parsedData);
