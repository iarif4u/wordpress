## Issues

- [ ] I think we need to remove WP REST dependencies (Rest API can be disabled for some sites as well, also permalink stracture can a issue)
- [ ] Currently, this plugin only with php 7.4. But we need to support upto 5.6
- [ ] Maybe better if we can run phpunit tests on all php versions?
- [ ] Need to run test on multiple versions
- [ ] WP MultiSite

## MVP

- [x] Basic WordPress Plugin
- [x] Settings Page (to save token from xCloud)
- [x] Token based authentication
- [x] Rest API for site migrations
- [x] Encryption
- [x] Add an item

# API Endpoints

- [x] /abspath
- [x] /wp_config
- [x] /db/tables
- [x] /db/table_structure
- [x] /fs/read
- [x] /db/table_data
- [x] /fs/structure
