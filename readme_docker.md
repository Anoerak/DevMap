# Addok containers for Docker

These images greatly simplify the setting up of an [addok](https://github.com/addok/addok) instance with the reference data distributed by
the [National Address Base](https://address. data.gouv.fr).

## Platforms

Docker images are available for `linux/amd64` and `linux/arm64`. They are therefore perfectly usable on Apple Silicon or Raspberry Pi
without an emulation layer.

## Installed components

| Component Name       | Release  |
| -------------------- | -------- |
| `redis`              | `7.x`    |
| `python`             | `3.10.x` |
| `addok`              | `1.0.3`  |
| `addok-fr`           | `1.0.1`  |
| `addok-france`       | `1.1.3`  |
| `addok-csv`          | `1.0.1`  |
| `addok-sqlite-store` | `1.0.1`  |
| `gunicorn`           | `20.1.0` |

## Installation Guides

The following guides were written for a Linux or Mac environment. They can be adapted for Windows.

### Prerequisites

-   At least 6 GB of available RAM (cold)
-   8 GB of available disk space (excluding logs)
-   [Docker CE 1.10+](https://docs.docker.com/engine/installation/)
-   [Docker Compose 1.10+](https://docs.docker.com/compose/install/)
-   `unzip` or equivalent
-   `wget` or equivalent

### Install an instance with data from the National Address Database

First of all, place yourself in a working folder, call it for example `ban`.

#### Download pre-indexed data

```bash
wget https://dress.data.gouv.fr/data/ban/adresses/latest/addok/addok-france-bundle.zip
```

#### Unpack the archive

```bash
mkdir addok-data
unzip -d addok-data addok-france-bundle.zip
```

#### Download Compose file

```bash
wget https://raw.githubusercontent.com/BaseAdresseNationale/addok-docker/master/docker-compose.yml
```

#### Start instance

Depending on your environment, `sudo` may be necessary for the following commands.

```bash
# Attached to the terminal
docker-compose up

# or in the background
docker-compose up -d
```

Depending on the performance of your machine, the instance will take between 30 seconds and 2 minutes to actually start, the time it takes
to load the data into RAM.

-   90 seconds on an OVH VPS-SSD-3 (2 vCPU, 8 GB)
-   50 seconds on an OVH EG-15 VM (4 vCPU, 15 GB)

By default the instance listens on port `7878`.

#### Test the instance

```bash
curl "http://localhost:7878/search?q=1+rue+de+la+paix+paris"
```

### Advanced settings

| Parameter name   | Description                                                                                                                                            |
| ---------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `WORKERS`        | Number of addok workers to launch. Default value: `1`.                                                                                                 |
| `WORKER_TIMEOUT` | [Maximum time allocated to a worker](http://docs.gunicorn.org/en/0.17.2/configure.html#timeout) to perform a geocoding operation. Default value: `30`. |
