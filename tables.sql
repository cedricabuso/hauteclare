CREATE TABLE emp(
	empnum int PRIMARY KEY,
	name varchar(80),
	sex varchar(10),
	address varchar(80),
	hire_date date
);

CREATE TABLE owner(
	name varchar(80),
	username varchar(60) NOT NULL,
	pword varchar(60),
	CONSTRAINT owner_pkey PRIMARY KEY (username)
);

CREATE TABLE customer(
	name varchar(80),
	email varchar(30),
	address varchar(70)
);

CREATE TABLE product(
	prod_id int PRIMARY KEY,
	prod_name varchar(60),
	prod_desc varchar(80),
	prod_img varchar(60),
	prod_price int,
	exp_date date,
	mfg_date date
);

CREATE TABLE inventory(
	prod_id int REFERENCES product(prod_id),
	prod_quantity int,
	inv_date date
);

CREATE TABLE cashier(
	prod_id int REFERENCES product(prod_id),
	prod_name varchar(60),
	prod_quantity int,
	prod_price int,
	cash_date date
);

CREATE TABLE __user(
	id serial PRIMARY KEY,
	uname varchar(60),
	pword varchar(30),
	user_role varchar(10)
);

CREATE TABLE comments(
  comment_name character varying(140),
  comment_email character varying(30),
  comment_text character varying(140),
  comment_date character varying(50)
);

CREATE TABLE bulkorder(
	prod_id int REFERENCES product(prod_id),
	prod_name varchar(60),
	prod_quantity int,
	prod_amount int,
	bulk_order_date date
);

