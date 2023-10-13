-   Addok containers for Docker

These images make it possible to greatly simplify the establishment of an instance [addok (https://github.com/addok/addok) with the
reference data disseminated by the [Base Nationale Address (https://addok.data.gouv.fr).

-   Platforms

The Docker images are available for 'linux/amd64' and 'linux/arm64'. They can therefore be used perfectly on Apple Silicon or Raspberry Pi
without an emulation layer.

-   Components installed

-   Component name - Version -

---

"Redise - 7.x" "python" "3.10.x" "addok" "1.0.3" "addok-en" - 1.0.1 "addok-france" "1.1.3" "addok-csv" - 1.0.1 "addok-sqlite-store" - 1.0.1
"Gunicorn" "20.1.0"

-   Installation guides

The following guides were written for a Linux or Mac environment. They can be adapted for Windows.

-   Prerequisites

At least 6 GB of available RAM (cold) 8 GB of available disk space (excluding logs)

-   [Docker CE 1.10 (https://docs.docker.com/engine/installation/)
-   [Docker Compose 1.10 (https://docs.docker.com/compose/install/) "unzip" or equivalent
-   wget or equivalent

-   Install a body with the data of the National Address database

First of all, put yourself in a work folder, call it, for example, ban.

-   Download pre-indexed data

Bashash wget https://address.data.gouv.fr/data/ban/addest/addest/addok/addok-france-bundle.zip

-   -

Decompressing the archive

Bashash mkdir addok-data unzip -d addok-data addok-france-bundle.zip

-   -

Download the Compose file

Bashash wget https://raw.githubusercontent.com/BaseNational Address/addok-docker/master/docker-compose.yml

-   -

-   Starting the case

Depending on your environment, the following commands may be required.

Bashash

-   Attaché at the Terminal docker-compose up

-   or in the background docker-compose up -d
-   -

Depending on the performance of your machine, the instance will take between 30 seconds and 2 minutes to actually start, the time to load
the data into the RAM.

90 seconds on a VPS-SSD-3 OVH (2 vCPU, 8 GB) 50 seconds on a VM EG-15 OVH (4 vCPU, 15 GB)

By default, the instance is listening on the port.

-   Testing the case

Bashash curl
"http://localhost:7878/search?q-1-lur-de-----------------------------------------------------------------------------------------------------

-   -

-   Advanced parameters

-   Name of parameter - Description -

---

Number of workers addok to be launched. Default value: 1. - - [Maximum assigned to a worker
(http://docs.gunicorn.org/en/0.17.2/configure.html-timeout) to perform a geocoding operation. Default value: 30. - -
