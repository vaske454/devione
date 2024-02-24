import React, { useState } from 'react';
import axios from 'axios';

const WordInput = () => {
    const [word, setWord] = useState('');
    const [score, setScore] = useState(null);
    const [error, setError] = useState(null);

    const handleChange = (event) => {
        setWord(event.target.value);
    }

    const handleSubmit = async (event) => {
        event.preventDefault();

        try {
            const response = await axios.post('/api/check-word', { word });
            setScore(response.data.score);
            setError(null); // Reset error state
        } catch (error) {
            console.error('Error:', error);
            setError('The entered word is not a valid English word'); // Set error message
            setScore(null); // Reset score state
        }
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
                />
                <button type="submit" className="word-input-submit">Submit</button>
            </form>
            {error && <p style={{ color: 'red' }}>{error}</p>}
            {!error && score !== null && <p>Score: {score}</p>}
        </div>
    );
};

export default WordInput;
