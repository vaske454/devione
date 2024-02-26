import React, { useState } from 'react';
import axios from 'axios';

const WordInput = () => {
    const [word, setWord] = useState('');
    const [score, setScore] = useState(null);
    const [error, setError] = useState(null);

    const handleChange = (event) => {
        const inputValue = event.target.value.replace(/\s/g, ''); // Remove spaces
        if (inputValue.length <= 50) { // Check if input length is less than or equal to 50
            setWord(inputValue);
        }
    }

    const handleSubmit = async (event) => {
        event.preventDefault();

        if (word.length < 2) {
            setError('Word must have at least 2 letters.');
            return;
        }

        if (!/^[A-Za-z]+$/.test(word)) {
            setError('Only letters are allowed.');
            return;
        }

        try {
            const response = await axios.post('/api/check-word', { word });
            setScore(response.data.score);
            setError(null); // Reset error state
        } catch (error) {
            // Check if there is a response and a message
            if (error.response && error.response.data && error.response.data.message) {
                // Get the message from the response
                const errorMessage = error.response.data.message;
                // Try to extract the title
                const titleIndex = errorMessage.indexOf('title');
                const messageIndex = errorMessage.indexOf('message');
                if (titleIndex !== -1 && messageIndex !== -1) {
                    // Get the substring with the title
                    const titleSubstring = errorMessage.substring(titleIndex + 8, messageIndex - 4);
                    setError(titleSubstring);
                } else {
                    // If there is no title, set a general error
                    setError('Unknown error occurred.');
                }
            } else {
                // If there is no response or message, set a general error
                setError('Unknown error occurred.');
            }
            setScore(null); // Reset score state
        }

    }

    const handlePaste = (event) => {
        const pastedText = event.clipboardData.getData('text');
        if (!/[^A-Za-z]/.test(pastedText) && pastedText.length <= 50) {
            setWord(pastedText.slice(0, 50)); // Set only the first 50 characters
        }
        event.preventDefault(); // Prevent default paste behavior
    }

    return (
        <div className="word-input-container">
            <form className="word-input-form" onSubmit={handleSubmit}>
                <input
                    type="text"
                    placeholder="Enter a word"
                    className="word-input-field"
                    value={word}
                    onChange={handleChange}
                    onKeyPress={(e) => {
                        if (!/[A-Za-z]/.test(e.key)) {
                            e.preventDefault();
                        }
                    }}
                    onPaste={handlePaste} // Handle paste event
                />
                <button type="submit" className="word-input-submit">Submit</button>
            </form>
            {error && <p style={{ color: 'red' }}>{error}</p>}
            {!error && score !== null && <p>Score: {score}</p>}
        </div>
    );
};

export default WordInput;
