package com.cinema.dao;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

import com.cinema.db.CinemaDb;
import com.cinema.model.Movie;

public class MovieDao {

	private Connection connection;

	public MovieDao() throws ClassNotFoundException, SQLException {
		this.connection = CinemaDb.getConnection();
	}

	public List<Movie> getAllMovies() throws SQLException {
		List<Movie> movies = new ArrayList<Movie>();

		// retrieve all movies from the database
		String query = "SELECT * FROM movies";
		PreparedStatement statement = connection.prepareStatement(query);
		ResultSet resultSet = statement.executeQuery();

		// create a Movie object for each row in the result set
		while (resultSet.next()) {
			int movieId = resultSet.getInt("movie_id");
			String name = resultSet.getString("name");
			String imageUrl = resultSet.getString("image_url");
			Movie movie = new Movie(movieId, name, imageUrl);
			movies.add(movie);
		}

		return movies;
	}

	public Movie getMovieById(int movieId) throws SQLException {
		// retrieve the movie with the specified ID from the database
		String query = "SELECT * FROM movies WHERE movie_id = ?";
		PreparedStatement statement = connection.prepareStatement(query);
		statement.setInt(1, movieId);
		ResultSet resultSet = statement.executeQuery();

		// create a Movie object for the row in the result set, if it exists
		if (resultSet.next()) {
			String name = resultSet.getString("name");
			String imageUrl = resultSet.getString("image_url");
			Movie movie = new Movie(movieId, name, imageUrl);
			return movie;
		} else {
			return null;
		}
	}

	public List<Movie> searchMovies(String keyword) throws SQLException {
		List<Movie> movies = new ArrayList<Movie>();

		// search for movies that match the specified keyword in their name or
		// description
		String query = "SELECT * FROM movies WHERE name LIKE ? OR description LIKE ?";
		PreparedStatement statement = connection.prepareStatement(query);
		statement.setString(1, "%" + keyword + "%");
		statement.setString(2, "%" + keyword + "%");
		ResultSet resultSet = statement.executeQuery();

		// create a Movie object for each row in the result set
		while (resultSet.next()) {
			int movieId = resultSet.getInt("movie_id");
			String name = resultSet.getString("name");
			String imageUrl = resultSet.getString("image_url");
			Movie movie = new Movie(movieId, name, imageUrl);
			movies.add(movie);
		}

		return movies;
	}
	
	public void addMovie(Movie movie) throws SQLException {
	    String query = "INSERT INTO movies (name, image_url) VALUES (?, ?)";

	    try (PreparedStatement statement = connection.prepareStatement(query)) {
	        statement.setString(1, movie.getName());
	        statement.setString(2, movie.getImageUrl());
	        statement.executeUpdate();
	    } catch (SQLException e) {
	        throw e;
	    }
	}


	public void updateMovie(Movie movie) throws SQLException {
		String query = "UPDATE movies SET name = ?, image_url = ? WHERE movie_id = ?";
		PreparedStatement statement = connection.prepareStatement(query);
		statement.setString(1, movie.getName());
		statement.setString(2, movie.getImageUrl());
		statement.setInt(3, movie.getId());
		statement.executeUpdate();
	}

	public void deleteMovie(int movieId) throws SQLException {
		String sql = "DELETE FROM movies WHERE movie_id = ?";
		try (PreparedStatement stmt = connection.prepareStatement(sql)) {
			stmt.setInt(1, movieId);
			stmt.executeUpdate();
		} catch (SQLException e) {
			throw e;
		}
	}

	// Dummy Data
	public List<Movie> getDummyMovies() {
		List<Movie> movies = new ArrayList<>();
		movies.add(new Movie(1, "The Shawshank Redemption", "https://www.example.com/shawshank_redemption.jpg"));
		movies.add(new Movie(2, "The Godfather", "https://www.example.com/godfather.jpg"));
		movies.add(new Movie(3, "The Dark Knight", "https://www.example.com/dark_knight.jpg"));
		return movies;
	}
}
