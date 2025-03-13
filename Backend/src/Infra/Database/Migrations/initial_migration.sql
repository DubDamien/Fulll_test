CREATE TABLE IF NOT EXISTS fleets (
    id VARCHAR(255) PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS locations (
    id VARCHAR(255) PRIMARY KEY,
    lat FLOAT NOT NULL,
    lng FLOAT NOT NULL,
    alt FLOAT
);

CREATE TABLE IF NOT EXISTS vehicles (
    id VARCHAR(255) PRIMARY KEY,
    plate_number VARCHAR(255) NOT NULL UNIQUE,
    location_id VARCHAR(255),
    FOREIGN KEY (location_id) REFERENCES locations(id)
);

CREATE TABLE IF NOT EXISTS fleets_vehicles (
    fleet_id VARCHAR(255),
    vehicle_id VARCHAR(255),
    PRIMARY KEY (fleet_id, vehicle_id),
    FOREIGN KEY (fleet_id) REFERENCES fleets(id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id)
);