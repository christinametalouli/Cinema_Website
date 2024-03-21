package com.cinema.dao;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

import com.cinema.db.CinemaDb;
import com.cinema.model.User;

public class UserDao {

	private final Connection connection;

	public UserDao() throws ClassNotFoundException, SQLException {
		this.connection = CinemaDb.getConnection();
	}
	
	public User authenticate(String username, String password) {
	    String query = "SELECT * FROM users WHERE username = ? AND password = ?";
	    try (PreparedStatement statement = connection.prepareStatement(query)) {
	        statement.setString(1, username);
	        statement.setString(2, password);
	        try (ResultSet resultSet = statement.executeQuery()) {
	            if (resultSet.next()) {
	                return extractUserFromResultSet(resultSet);
	            } else {
	                return null;
	            }
	        }
	    } catch (SQLException e) {
	        return null;
	    }
	}


	public void create(User user) {
		try (PreparedStatement statement = connection.prepareStatement(
				"INSERT INTO users (first_name, last_name, country, city, address, email, username, password, role_id) "
						+ "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
			statement.setString(1, user.getFirstName());
			statement.setString(2, user.getLastName());
			statement.setString(3, user.getCountry());
			statement.setString(4, user.getCity());
			statement.setString(5, user.getAddress());
			statement.setString(6, user.getEmail());
			statement.setString(7, user.getUsername());
			statement.setString(8, user.getPassword());
			statement.setInt(9, user.getRoleId());
			statement.executeUpdate();
		} catch (SQLException e) {
			throw new RuntimeException("Error creating user", e);
		}
	}
	
	public void update(User user) {
		try (PreparedStatement statement = connection.prepareStatement(
				"UPDATE users SET first_name = ?, last_name = ?, country = ?, city = ?, address = ?, email = ?, username = ?, password = ?, role_id = ? WHERE user_id = ?")) {
			statement.setString(1, user.getFirstName());
			statement.setString(2, user.getLastName());
			statement.setString(3, user.getCountry());
			statement.setString(4, user.getCity());
			statement.setString(5, user.getAddress());
			statement.setString(6, user.getEmail());
			statement.setString(7, user.getUsername());
			statement.setString(8, user.getPassword());
			statement.setInt(9, user.getRoleId());
			statement.setInt(10, user.getUserId());
			statement.executeUpdate();
		} catch (SQLException e) {
			throw new RuntimeException("Error updating user", e);
		}
	}

	public void delete(int userId) {
		try (PreparedStatement statement = connection.prepareStatement("DELETE FROM users WHERE user_id = ?")) {
			statement.setInt(1, userId);
			statement.executeUpdate();
		} catch (SQLException e) {
			throw new RuntimeException("Error deleting user", e);
		}
	}

	public User findById(int userId) {
		try (PreparedStatement statement = connection.prepareStatement("SELECT * FROM users WHERE user_id = ?")) {
			statement.setInt(1, userId);
			try (ResultSet resultSet = statement.executeQuery()) {
				if (resultSet.next()) {
					return extractUserFromResultSet(resultSet);
				} else {
					return null;
				}
			}
		} catch (SQLException e) {
			throw new RuntimeException("Error finding user by ID", e);
		}
	}

	public User findByUsername(String username) {
		try (PreparedStatement statement = connection.prepareStatement("SELECT * FROM users WHERE username = ?")) {
			statement.setString(1, username);
			try (ResultSet resultSet = statement.executeQuery()) {
				if (resultSet.next()) {
					return extractUserFromResultSet(resultSet);
				} else {
					return null;
				}
			}
		} catch (SQLException e) {
			throw new RuntimeException("Error finding user by username", e);
		}
	}

	public User findByEmail(String email) {
		try (PreparedStatement statement = connection.prepareStatement("SELECT * FROM users WHERE email = ?")) {
			statement.setString(1, email);
			try (ResultSet resultSet = statement.executeQuery()) {
				if (resultSet.next()) {
					return extractUserFromResultSet(resultSet);
				} else {
					return null;
				}
			}
		} catch (SQLException e) {
			throw new RuntimeException("Error finding user by email", e);
		}
	}

	public List<User> getAll() {
		List<User> userList = new ArrayList<>();
		Statement statement = null;
		ResultSet resultSet = null;

		try {
			statement = this.connection.createStatement();
			resultSet = statement.executeQuery("SELECT * FROM users");

			while (resultSet.next()) {
				User user = extractUserFromResultSet(resultSet);
				userList.add(user);
			}
		} catch (SQLException e) {
			e.printStackTrace();
			return null;
		} finally {
			try {
				if (resultSet != null)
					resultSet.close();
				if (statement != null)
					statement.close();
			} catch (SQLException e) {
				e.printStackTrace();
			}
		}

		return userList;
	}

	private User extractUserFromResultSet(ResultSet resultSet) throws SQLException {
		return new User(resultSet.getInt("user_id"), resultSet.getString("first_name"),
				resultSet.getString("last_name"), resultSet.getString("country"), resultSet.getString("city"),
				resultSet.getString("address"), resultSet.getString("email"), resultSet.getString("username"),
				resultSet.getString("password"), resultSet.getInt("role_id"));
	}
}
