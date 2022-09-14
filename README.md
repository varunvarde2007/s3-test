<h3>CloudFormation</h3>
The cloudformation file is stored in the root directory with name S3Creation.yml

<h5>PreRequisites</h5>

- AWS-Cli needs to be installed and configured on the machine

<h5>Deployment Steps</h5>

Run the following Command to generate the S3 bucket using CloudFormation

- aws cloudformation create-stack --stack-name friendsurance --template-body file://S3Creation.yaml

<h3>Code Deployment and Configuration</h3>

<h5>Pre-Requisites</h5>

- PHP 8.1

<h5> Deployment Steps </h5>

- Clone the repository
- Copy .env.example to .env
- run <b>composer install</b>
- run <b>php artisan key:generate</b>
- create database and update the .env file variable DB_Name
- run command php artisan migrate (this command generates the tables required)
- update the following variables in .env file
    - AWS_ACCESS_KEY_ID
    - AWS_SECRET_ACCESS_KEY
    - AWS_DEFAULT_REGION
    - AWS_BUCKET
- To start the dev server run php artisan serve

<h5>API Routes</h5>

The following api routes are available in this code

- Upload image - http://localhost:8000/api/upload
    - Method : "POST"
    - Content-Type: "application/json"
    - Body: <code>{"image" :"{{imageUrl}},"name":"{{name of the file}}"}</code>
    - Response
        - Success:
            - Status Code: 200
            - <code>{
              "status": true,
              "message": "Image Uploaded Successfully"
              }</code>
        - Error Uploading Image
            - Status Code: 400
            - <code>{
              "status": false,
              "message": "There was an issue uploading the file. Please try again"
              }</code>
        - Invalid Parameters (Image Name and URL are mandatory)
            - Status Code: 400
            - <code>{
              "status": false,
              "message": "Invalid Parameters"
              }</code>
- List of all images uploaded to s3 bucket
    - Method: "GET"
    - Response: <code>{"
      images":["images\/JaASoJio9Fy2rvLubmXQf1Nd2aAgKUBO.jpg","images\/MJeZ5OLLeDYMoGCeQAYBfL3u6ooJ7SiS.jpg","images\/cy7zNswJvnSwHlAErbisN2Cr90nyB2rO.jpg","images\/g88Y4m3VpGhGovokVBa5E56akQNGaJH6.jpg"]
      }</code>

