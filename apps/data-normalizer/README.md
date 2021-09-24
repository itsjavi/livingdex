# livingdex-data

Pokémon data normalisation tool.

The goal of this project is to be the most reusable and reliable Pokémon data source,
always using up-to-date data from other trusted projects like:
Showdown, Veekun DB & POGOProtos.

This project generates the data that is included in the `pokemon-assets`
project and it is used also by the `livingdex` project.

## Features

- First Pokémon data source aggregator, that also combines Pokemon GO data.
- Fully operative Symfony application that can be used as base back-end project too.
- Fully defined doctrine entities (with relationships) for all data structures, 
  to create a relational database schema.
- Exports the DB data to CSV and JSON files
- Fully dockerized setup for either generating the dist files or development.
- Data cross-checks between projects to assure that there are no mistakes or missing data.
- Assures maximum compatibility with the original data source projects 
  (e.g. keeping same internal IDs, storing original slugs, etc.).
- Command-line tool with many useful commands 
  e.g. to run SQL directly and show the results as JSON.
- Mini-site UI to demonstrate the correctness of the data.

## Installation

```bash

git clone git@github.com:itsjavi/livingdex-data.git && \
cd livingdex-data
```

### Releases
To generate everything in one go, just run:

```bash
make
```

This will use the `Dockerfile` multiple-stage build to generate the
dist folder. It may take a while the first time.

This is the preferred way to generate the `dist` folder, because it's simple and
it doesn't require you to do any additional step.

Keep in mind that exporting to CSV may have different
results depending on the DB engine 
(e.g. floats with trailing decimal zeros or without).

### Development & Maintenance

Most useful commands when developing:

```bash
# Start containers
make start

# Install dependencies
make docker-install

# Recreate DB from original data sources
make docker-db

# Recreate DB from dist CSV files (useful for double-checking integrity)
make docker-db-from-dist

# Opens your browser with the Mini-site UI and DB Adminer
make open

# Just exports DB to dist folder
make docker-dist

# A combination of make docker-db + make docker-dist
make docker-build
```

All make targets starting with `docker-` happen inside the phpfpm container of the docker-compose project.

### How to update the data sources?

Data sources come from the following repositories, so new semver tags will need to be released for:

- https://github.com/itsjavi/veekun-pokedex
- https://github.com/itsjavi/showdown-data  
- https://github.com/itsjavi/pogodata

Once the source projects are up to date, you need to update the version in
`composer.json` and run `composer update`.

After that, regenerate the `dist` exports by running `make build`.

## Usage

To list all the available commands: `bin/docker-console list app`.


### Running commands inside the container

Running any command inside the `phpfpm` container, e.g.:

```bash
bin/docker-exec ls -la
bin/docker-exec bin/console list
```

Running any Symfony Console command inside the `phpfpm` container, e.g.:

```bash

bin/docker-exec bin/console list
# or:
bin/docker-console list
```

### Creating new entities

```bash
  bin/docker-console make:entity LivingDex\\NewEntityName
```

### About the `dist` folder

- This directory is always generated automatically and is only meant
  to be here for debugging and source control purposes, to verify
  the correctness of the data sources and normalizers.

- Do not change the contents of this directory manually,
  change the `./src/` code instead, specially the DataSources and
  DataFixtures.

- Any manual changes to this directory will be gone whenever the
  project is built again.

- Any Pull Request making changes to the contents of this directory,
  which are not the result of running `make`
  will be automatically closed and discarded.


Thank you for your help to make this project better,
consistent and easy to upgrade and maintain!

## License

This software is copyrighted and licensed under the
[MIT license](https://github.com/itsjavi/livingdex-data/LICENSE).

### Disclaimer

This software comes bundled with data and graphics extracted from the
Pokémon series of video games. Some terminology from the Pokémon franchise is
also necessarily used within the software itself. This is all the intellectual
property of Nintendo, Creatures, inc., and GAME FREAK, inc. and is protected by
various copyrights and trademarks.

The authors believe that the use of this intellectual property for a fan reference
is covered by fair use and that the software is significantly impaired without said
property included. Any use of this copyrighted property is at your own legal risk.

This software is not affiliated in any way with Nintendo,
Pokémon or any other game company.

A complete revision history of this software is available in Github
[https://github.com/itsjavi/livingdex-data](https://github.com/itsjavi/livingdex-data)
