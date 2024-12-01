# database creation
create database if not exists gearguard character set = 'utf8mb4' collate = 'utf8mb4_general_ci';
-- select password('gearguard@pa$$w0rd');
-- # user creation
-- grant all privileges on gearguard.* to 'ggdbuser' @'%' identified by password '*EC2C67FBA641B44E153E1BCDA7537E40376315A7';
# select database
use gearguard;
# status table
create or replace table gearguard.gg_status (
        `id` INT auto_increment NOT NULL,
        `status` varchar(100) NOT NULL,
        CONSTRAINT gg_status_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_status_unique UNIQUE KEY (`status`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
# vehicle table
create or replace table gearguard.gg_vehicle (
        `id` INT auto_increment NOT NULL,
        vin int not null,
        model_id INT NOT NULL,
        year_manufactured DATE NULL,
        license_plate_no varchar(20) NOT NULL,
        class_id INT NOT null,
        engine_capacity_id INT NOT null,
        fuel_type_id INT NOT null,
        bodytype_id INT NOT null,
        insurance_no varchar(100) NULL,
        engine_no varchar(100) NOT NULL,
        current_user_id INT NULL,
        status_id int not null,
        CONSTRAINT gg_vehicle_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_vehicle_unique_engine_no UNIQUE KEY (engine_no),
        CONSTRAINT gg_vehicle_unique_vin UNIQUE KEY (vin),
        constraint gg_vehicle_unique_vin_license_plate unique key (vin, license_plate_no)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_vehicle_model (
        `id` INT auto_increment NOT NULL,
        model varchar(100) NOT NULL,
        manufacturer_id INT NOT NULL,
        CONSTRAINT gg_vehicle_model_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_vehicle_model_unique_model_manufacturer UNIQUE KEY (model, manufacturer_id)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_vehicle_manufacturer (
        `id` INT auto_increment NOT NULL,
        `name` varchar(100) NOT NULL,
        CONSTRAINT gg_vehicle_manufacturer_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_vehicle_manufacturer_unique UNIQUE KEY (`name`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_vehicle_class (
        `id` INT auto_increment NOT NULL,
        class varchar(10) NOT NULL,
        CONSTRAINT gg_vehicle_class_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_vehicle_class_unique UNIQUE KEY (class)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_vehicle_engine_capacity (
        `id` INT auto_increment NOT NULL,
        capacity varchar(10) NOT NULL,
        CONSTRAINT gg_vehicle_engine_capacity_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_vehicle_engine_capacity_unique UNIQUE KEY (capacity)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_vehicle_fueltype (
        `id` INT auto_increment NOT NULL,
        fueltype varchar(15) NOT NULL,
        CONSTRAINT gg_vehicle_fueltype_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_vehicle_fueltype_unique UNIQUE KEY (fueltype)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_vehicle_bodytype (
        `id` INT auto_increment NOT NULL,
        bodytype varchar(30) NOT NULL,
        CONSTRAINT gg_vehicle_bodytype_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_vehicle_bodytype_unique UNIQUE KEY (bodytype)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
# user table
create or replace table gearguard.gg_user (
        username varchar(30) NOT NULL,
        password varchar(255) not null,
        first_name varchar(30) NOT NULL,
        last_name varchar(30) NULL,
        `id` INT auto_increment NOT NULL,
        nic varchar(30) NOT NULL,
        address varchar(255) NOT NULL,
        email varchar(100) NOT NULL,
        contact_no varchar(100) NOT NULL,
        status_id int not null,
        CONSTRAINT gg_user_owner_unique_username UNIQUE KEY (username),
        CONSTRAINT gg_user_owner_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_user_owner_unique_nic UNIQUE KEY (nic),
        CONSTRAINT gg_user_owner_unique_email UNIQUE KEY (email),
        CONSTRAINT gg_user_owner_unique_contact UNIQUE KEY (contact_no)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_user_vehicleuser (
        user_id INT NOT NULL,
        license_no varchar(30) NOT null,
        constraint gg_user_vehicleuser_pk primary key (`user_id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_user_owner (
        vehicle_id INT NOT NULL,
        user_id INT NOT NULL,
        ownership_status_id INT NOT NULL,
        registration_date DATE null,
        CONSTRAINT gg_vehicle_user_owner_pk PRIMARY KEY (`user_id`, `vehicle_id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_owner_ownership_type (
        `id` INT auto_increment NOT NULL,
        ownership_type varchar(20) NOT NULL,
        CONSTRAINT gg_owner_ownership_type_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_owner_ownership_type_unique UNIQUE KEY (ownership_type)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_user_admin (user_id INT NOT NULL) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
# garage table
create or replace table gearguard.gg_garage_service (
        `id` INT auto_increment NOT NULL,
        `type` varchar(100) NOT null,
        `price` double not null,
        duration int,
        description text default null,
        `garage_id` INT not null,
        status_id int not null,
        CONSTRAINT gg_garage_service_pk PRIMARY KEY (`id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_garage (
        `id` INT auto_increment NOT NULL,
        username varchar(30) not null,
        password varchar(255) not null,
        `name` varchar(100) NOT NULL,
        address varchar(255) NOT NULL,
        email varchar(100) NOT NULL,
        contact_no varchar(100) NOT NULL,
        registration_no varchar(100) null,
        status_id int not null,
        CONSTRAINT gg_garage_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_garage_unique_name_address UNIQUE KEY (`name`, address),
        constraint gg_garage_unique_username unique key (username)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_garage_mechanic (
        username varchar(30) NOT NULL,
        password varchar(255) not null,
        first_name varchar(30) NOT NULL,
        last_name varchar(30) NULL,
        `id` INT auto_increment NOT NULL,
        nic varchar(30) NOT NULL,
        address varchar(255) NOT NULL,
        email varchar(100) NOT NULL,
        contact_no varchar(100) NOT null,
        date_employeed DATE not NULL,
        garage_id int not null,
        status_id int not null,
        CONSTRAINT gg_garage_mechanic_unique_username UNIQUE KEY (username),
        CONSTRAINT gg_garage_mechanic_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_garage_mechanic_unique_nic UNIQUE KEY (nic),
        CONSTRAINT gg_garage_mechanic_unique_email UNIQUE KEY (email),
        CONSTRAINT gg_garage_mechanic_unique_contact UNIQUE KEY (contact_no)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
# sparepart table
create or replace table gearguard.gg_sparepart (
        `id` INT auto_increment NOT NULL,
        serial_no varchar(100) NOT NULL,
        `type` varchar(150) NOT NULL,
        manufacturer varchar(100) NOT NULL,
        price DOUBLE NOT NULL,
        manufactured_date DATE NULL,
        waranty_period date NULL,
        CONSTRAINT gg_sparepart_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_sparepart_unique_serial UNIQUE KEY (serial_no)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
# relationship tables
create or replace table gearguard.gg_vehicle_assignments (
        vehicle_id INT NOT NULL,
        owner_id INT NOT NULL,
        user_id INT NOT NULL,
        date_assigned DATE NOT NULL,
        CONSTRAINT gg_vehicle_assignments_pk PRIMARY KEY (vehicle_id, owner_id, user_id)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_vehicle_service_take (
        vehicle_id INT NOT NULL,
        service_id INT NOT NULL,
        mechanic_id INT not null,
        begin_timestamp DATETIME NOT NULL,
        end_timestamp DATETIME NOT NULL,
        duration DATETIME null,
        notes text default null
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_vehicle_service_appointment (
        vehicle_id INT NOT NULL,
        service_id INT NOT NULL,
        `date` DATE NOT NULL,
        `time` TIME NOT null,
        notes text default null
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace TABLE gearguard.gg_service_mechanic_perform (
        service_id INT NOT NULL,
        mechanic_id INT NOT null,
        constraint gg_garage_mechanic_perform_pk primary key (`service_id`, `mechanic_id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace TABLE gearguard.gg_sparepart_service_vehicle_install (
        vehicle_id int NOT NULL,
        service_id int NOT NULL,
        sparepart_id int NOT NULL,
        installed_date DATE NOT null,
        constraint gg_sparepart_service_vehicle_install_pk primary key (service_id, sparepart_id)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace TABLE gearguard.gg_sparepart_vehicleuser_vehicle_install (
        vehicle_id int NOT NULL,
        user_id int NOT NULL,
        sparepart_id int NOT NULL,
        installed_date DATE NOT null,
        constraint gg_sparepart_vehicleuser_vehicle_install_pk primary key (user_id, sparepart_id)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
# forum tables
create or replace table gearguard.gg_forum_topic (
        `id` int auto_increment NOT NULL,
        title varchar(255) NOT NULL,
        CONSTRAINT gg_forum_topic_pk PRIMARY KEY (`id`),
        CONSTRAINT gg_forum_topic_unique_title UNIQUE KEY (title)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_forum_post (
        topic_id INT NOT NULL,
        user_id INT NOT NULL,
        `id` INT NOT NULL,
        content TEXT NOT NULL,
        `timestamp` TIMESTAMP NOT null,
        constraint gg_forum_post_pk primary key (topic_id, user_id),
        CONSTRAINT gg_forum_post_unique UNIQUE KEY (`id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_forum_comment (
        post_id INT NOT NULL,
        user_id INT NOT NULL,
        `id` INT NOT NULL,
        content TEXT NOT NULL,
        `timestamp` TIMESTAMP NOT NULL,
        constraint gg_forum_comment_pk primary key (post_id, user_id),
        CONSTRAINT gg_forum_comment_unique UNIQUE KEY (`id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
create or replace table gearguard.gg_forum_reply (
        comment_id INT NOT NULL,
        user_id INT NOT NULL,
        `id` INT NOT NULL,
        content TEXT NOT NULL,
        `timestamp` TIMESTAMP NOT NULL,
        constraint gg_forum_reply_pk primary key (comment_id, user_id),
        CONSTRAINT gg_forum_reply_unique UNIQUE KEY (`id`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
# adding foreign keys
alter table gearguard.gg_vehicle
ADD CONSTRAINT gg_vehicle_gg_vehicle_model_fk FOREIGN KEY (model_id) REFERENCES gearguard.gg_vehicle_model(`id`);
alter table gearguard.gg_vehicle
ADD CONSTRAINT gg_vehicle_gg_vehicle_class_fk FOREIGN KEY (class_id) REFERENCES gearguard.gg_vehicle_class(`id`);
alter table gearguard.gg_vehicle
ADD CONSTRAINT gg_vehicle_gg_vehicle_engine_capacity_fk FOREIGN KEY (engine_capacity_id) REFERENCES gearguard.gg_vehicle_engine_capacity(`id`);
alter table gearguard.gg_vehicle
ADD CONSTRAINT gg_vehicle_gg_user_vehicleuser_fk FOREIGN KEY (current_user_id) REFERENCES gearguard.gg_user_vehicleuser(user_id);
alter table gearguard.gg_vehicle
ADD CONSTRAINT gg_vehicle_gg_status_fk FOREIGN KEY (status_id) REFERENCES gearguard.gg_status(`id`);
alter table gearguard.gg_vehicle_model
ADD CONSTRAINT gg_vehicle_model_gg_vehicle_manufacturer_fk FOREIGN KEY (manufacturer_id) REFERENCES gearguard.gg_vehicle_manufacturer(`id`);
alter table gearguard.gg_vehicle
ADD CONSTRAINT gg_vehicle_gg_vehicle_fueltype_fk FOREIGN KEY (fuel_type_id) REFERENCES gearguard.gg_vehicle_fueltype(`id`);
alter table gearguard.gg_vehicle
ADD CONSTRAINT gg_vehicle_gg_vehicle_bodytype_fk FOREIGN KEY (bodytype_id) REFERENCES gearguard.gg_vehicle_bodytype(`id`);
alter table gearguard.gg_user
add constraint gg_user_gg_status_fk foreign key (status_id) references gearguard.gg_status(`id`);
alter table gearguard.gg_user_vehicleuser
ADD CONSTRAINT gg_user_vehicleuser_gg_user_fk FOREIGN KEY (user_id) REFERENCES gearguard.gg_user(`id`);
alter table gearguard.gg_user_owner
ADD CONSTRAINT gg_user_owner_gg_vehicle_fk FOREIGN KEY (vehicle_id) REFERENCES gearguard.gg_vehicle(`id`);
alter table gearguard.gg_user_owner
ADD CONSTRAINT gg_user_owner_gg_user_fk FOREIGN KEY (user_id) REFERENCES gearguard.gg_user(`id`);
alter table gearguard.gg_user_owner
ADD CONSTRAINT gg_user_owner_gg_owner_ownership_type_fk FOREIGN KEY (ownership_status_id) REFERENCES gearguard.gg_owner_ownership_type(`id`);
ALTER TABLE gearguard.gg_vehicle_assignments
ADD CONSTRAINT gg_vehicle_assignments_gg_vehicle_FK FOREIGN KEY (vehicle_id) REFERENCES gearguard.gg_vehicle(`id`);
ALTER TABLE gearguard.gg_vehicle_assignments
ADD CONSTRAINT gg_vehicle_assignments_gg_user_vehicleuser_fk FOREIGN KEY (user_id) REFERENCES gearguard.gg_user_vehicleuser(user_id);
ALTER TABLE gearguard.gg_vehicle_assignments
ADD CONSTRAINT gg_vehicle_assignments_gg_user_owner_fk FOREIGN KEY (owner_id, vehicle_id) REFERENCES gearguard.gg_user_owner(user_id, vehicle_id);
ALTER TABLE gearguard.gg_vehicle_service_take
ADD CONSTRAINT gg_vehicle_service_take_gg_vehicle_FK FOREIGN KEY (vehicle_id) REFERENCES gearguard.gg_vehicle(`id`);
ALTER TABLE gearguard.gg_vehicle_service_take
ADD CONSTRAINT gg_vehicle_service_take_gg_garage_service_FK FOREIGN KEY (service_id) REFERENCES gearguard.gg_garage_service(`id`);
ALTER TABLE gearguard.gg_vehicle_service_take
ADD CONSTRAINT gg_vehicle_service_take_gg_garage_mechanic_FK FOREIGN KEY (mechanic_id) REFERENCES gearguard.gg_garage_mechanic(`id`);
alter table gearguard.gg_vehicle_service_appointment
add CONSTRAINT gg_vehicle_service_appointment_gg_vehicle_FK FOREIGN KEY (vehicle_id) REFERENCES gearguard.gg_vehicle(`id`);
alter table gearguard.gg_vehicle_service_appointment
add CONSTRAINT gg_vehicle_service_appointment_gg_garage_service_FK FOREIGN KEY (service_id) REFERENCES gearguard.gg_garage_service(`id`);
alter table gearguard.gg_garage
add constraint gg_garage_gg_status_fk foreign key (status_id) references gearguard.gg_status (`id`);
ALTER TABLE gearguard.gg_garage_mechanic
ADD CONSTRAINT gg_garage_mechanic_gg_garage_FK FOREIGN KEY (garage_id) REFERENCES gearguard.gg_garage(`id`);
ALTER TABLE gearguard.gg_garage_mechanic
ADD CONSTRAINT gg_garage_mechanic_gg_status_FK FOREIGN KEY (status_id) REFERENCES gearguard.gg_status(`id`);
alter table gearguard.gg_garage_service
add constraint gg_garage_service_gg_status_fk foreign key (status_id) references gearguard.gg_status(`id`);
ALTER TABLE gearguard.gg_garage_service
ADD CONSTRAINT gg_garage_service_gg_garage_FK FOREIGN KEY (garage_id) REFERENCES gearguard.gg_garage(`id`);
ALTER TABLE gearguard.gg_garage_service
ADD CONSTRAINT gg_garage_service_unique UNIQUE KEY (garage_id, `type`);
ALTER TABLE gearguard.gg_service_mechanic_perform
ADD CONSTRAINT gg_service_mechanic_perform_gg_garage_service_FK FOREIGN KEY (service_id) REFERENCES gearguard.gg_garage_service(`id`);
ALTER TABLE gearguard.gg_service_mechanic_perform
ADD CONSTRAINT gg_service_mechanic_perform_gg_garage_mechanic_FK FOREIGN KEY (mechanic_id) REFERENCES gearguard.gg_garage_mechanic(`id`);
ALTER TABLE gearguard.gg_sparepart_service_vehicle_install
ADD CONSTRAINT gg_sparepart_service_vehicle_install_gg_garage_service_FK FOREIGN KEY (service_id) REFERENCES gearguard.gg_garage_service(`id`);
ALTER TABLE gearguard.gg_sparepart_service_vehicle_install
ADD CONSTRAINT gg_sparepart_service_vehicle_install_gg_sparepart_FK FOREIGN KEY (sparepart_id) REFERENCES gearguard.gg_sparepart(`id`);
ALTER TABLE gearguard.gg_sparepart_service_vehicle_install
ADD CONSTRAINT gg_sparepart_service_vehicle_install_gg_vehicle_FK FOREIGN KEY (vehicle_id) REFERENCES gearguard.gg_vehicle(`id`);
ALTER TABLE gearguard.gg_sparepart_vehicleuser_vehicle_install
ADD CONSTRAINT gg_sparepart_vehicleuser_vehicle_install_gg_sparepart_FK FOREIGN KEY (sparepart_id) REFERENCES gearguard.gg_sparepart(`id`);
ALTER TABLE gearguard.gg_sparepart_vehicleuser_vehicle_install
ADD CONSTRAINT gg_sparepart_vehicleuser_vehicle_install_gg_user_vehicleuser_FK FOREIGN KEY (user_id) REFERENCES gearguard.gg_user_vehicleuser(user_id);
ALTER TABLE gearguard.gg_user_admin
ADD CONSTRAINT gg_user_admin_gg_user_FK FOREIGN KEY (user_id) REFERENCES gearguard.gg_user(`id`);
ALTER TABLE gearguard.gg_forum_post
ADD CONSTRAINT gg_forum_post_gg_forum_topic_FK FOREIGN KEY (topic_id) REFERENCES gearguard.gg_forum_topic(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE gearguard.gg_forum_post
ADD CONSTRAINT gg_forum_post_gg_user_FK FOREIGN KEY (user_id) REFERENCES gearguard.gg_user(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE gearguard.gg_forum_comment
ADD CONSTRAINT gg_forum_comment_gg_forum_post_FK FOREIGN KEY (post_id) REFERENCES gearguard.gg_forum_post(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE gearguard.gg_forum_comment
ADD CONSTRAINT gg_forum_comment_gg_user_FK FOREIGN KEY (user_id) REFERENCES gearguard.gg_user(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE gearguard.gg_forum_reply
ADD CONSTRAINT gg_forum_reply_gg_forum_comment_FK FOREIGN KEY (comment_id) REFERENCES gearguard.gg_forum_comment(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE gearguard.gg_forum_reply
ADD CONSTRAINT gg_forum_reply_gg_user_FK FOREIGN KEY (user_id) REFERENCES gearguard.gg_user(`id`) ON DELETE CASCADE ON UPDATE CASCADE;
# adding indices
create or replace index gg_vehicle_service_appointment_date_IDX USING BTREE ON gearguard.gg_vehicle_service_appointment (`date`);
create or replace index gg_garage_id_IDX using btree ON gg_garage (id, username, name);
create or replace index gg_user_id_IDX using btree ON gg_user (id, username, first_name);
create or replace INDEX gg_garage_mechanic_id_IDX using btree ON gg_garage_mechanic (id, username, first_name);
# creating views
create or replace view gg_users_all_view as with all_users AS (
        (
            SELECT id,
                name,
                username,
                password,
                'gg_garage' as source_table
            FROM gg_garage
        )
        union all
        (
            SELECT id,
                first_name AS name,
                username,
                password,
                'gg_user' as source_table
            FROM gg_user
        )
        union all
        (
            SELECT id,
                first_name AS name,
                username,
                password,
                'gg_garage_mechanic' as source_table
            FROM gg_garage_mechanic
        )
    )
SELECT ROW_NUMBER() OVER (
        ORDER BY id,
            username,
            name
    ) AS unique_id,
    id,
    name,
    username,
    password,
    source_table
FROM all_users;
create or replace view gg_users_owners_view as
select u.username,
    u.password,
    u.first_name,
    u.last_name,
    u.id,
    u.nic,
    u.address,
    u.email,
    u.contact_no,
    u.status_id,
    uo.vehicle_id,
    uo.ownership_status_id,
    uo.registration_date
from gg_user u
    right join gg_user_owner uo on u.id = uo.user_id;
create or replace view gg_users_vehicleusers_view as
select u.username,
    u.password,
    u.first_name,
    u.last_name,
    u.id,
    u.nic,
    u.address,
    u.email,
    u.contact_no,
    u.status_id,
    uv.license_no
from gg_user u
    right join gg_user_vehicleuser uv on u.id = uv.user_id;
# adding data
insert into gearguard.gg_status (`status`)
values ('Inactive'),
    ('active'),
    ('deleted');