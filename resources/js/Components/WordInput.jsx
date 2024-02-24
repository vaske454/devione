import React, { useState } from 'react';

const WordInput = () => {
    return (
        <div className="word-input-container">
            <form className="word-input-form">
                <input
                    type="text"
                    placeholder="Enter a word"
                    className="word-input-field"
                />
                <button type="submit"
                        className="word-input-submit">
                    Submit
                </button>
            </form>
        </div>
    );
};

export default WordInput;
