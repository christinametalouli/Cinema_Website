package com.cinema.db;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class CinemaDb {
	private static final String DB_URL = "jdbc:mysql://localhost:3306/cinema";
	private static final String DB_USER = "root";
	private static final String DB_PASSWORD = "root";

	public static Connection getConnection() throws ClassNotFoundException, SQLException {
		Class.forName("com.mysql.cj.jdbc.Driver");
		return DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
	}

	public static void closeConnection(Connection connection) throws SQLException {
		if (connection != null && !connection.isClosed()) {
			connection.close();
		}

	}
}
