# Electricity Service

This repository contains the code for the Electricity Service, which consists of two services: the Tariff Provider Service and the Electricity App Service.

## Prerequisites

Before running the services, make sure you have the following prerequisites:

- Docker
- Docker Compose
- You have to have these ports available on your machine.
  - 80 [APP Port]
  - 8080 [Provider Port]
  - 3306 [Provider MYSQL Port]

## Getting Started

To get started with the Electricity Service, follow these steps:

1. Clone this repository.
2. Navigate to the root directory of the project.

### Starting the Services

To start the services, run the following command:

```shell
make up
```

This will build and start the Tariff Provider Service and the Electricity App Service in the background.

### How to run

Open the <a href="http://localhost/api" target="_blank">App</a>

Open the <a href="http://localhost:8080/api">Provider</a>

### Stopping the Services

To stop the services, run the following command:

```shell
make down
```

This will stop and remove the Tariff Provider Service and the Electricity App Service containers.

### Running Tests

To run tests for the Electricity App Service, run the following command:

```shell
make test
```

This will execute the tests for the Electricity App Service.

### License

This project is licensed under the MIT License.
