import React, { useState } from 'react';
import axios from 'axios';

const WordInput = () => {
    const [word, setWord] = useState('');
    const [score, setScore] = useState(null);

    const handleChange = (event) => {
        setWord(event.target.value);
    }

    const handleSubmit = async (event) => {
        event.preventDefault();

        try {
            const response = await axios.post('/api/check-word', { word });
            setScore(response.data.score);
        } catch (error) {
            console.error('Error:', error);
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
            {score !== null && <p>Score: {score}</p>}
        </div>
    );
};

export default WordInput;
