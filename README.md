# Survey Analytics

This repository contains the source code for the Survey Analytics project.

## Getting Started

To get started with the project, follow the steps below:

1. **Clone the repository:**

   ```shell
   git clone https://github.com/NaghamHalabi/survey-analytics.git

2. **Navigate to the project directory:**

   ```shell
   cd survey-analytics
 
3. **Install the project dependencies:**

    ```shell
    composer install
    
4. **Create the .env file:**

    ```shell
    Create a copy of the .env.example file and name it .env
    
5. **Start the development server:**

    ```shell
    php artisan serve --port=8080

6. **Add a directory for data storage:**

    ```shell
    Create a directory named 'data' inside the storage/app directory and place your JSON files there. This directory will be used for storing the JSON data.
    Note: The 'data' folder should contain the files issues by the other party
    
7. **The json files should have the following format:**  
    ```shell
    {
    "survey": {
        "name": "Melun",
        "code": "XX3"
    },
    "questions": [{
        "type": "qcm",
        "label": "What best sellers are available in your store?",
        "options": ["Product 1", "Product 2", "Product 3", "Product 4", "Product 5", "Product 6"],
        "answer": [true, false, true, true, true, true]
    }, {
        "type": "numeric",
        "label": "Number of products?",
        "options": null,
        "answer": 6200
    }]
}
