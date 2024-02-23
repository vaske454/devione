import React, { useState } from 'react';

const WordInput = () => {
    return (
        <div className="mt-8 max-w-md mx-auto">
            <form className="flex items-center border-b border-b-2 border-teal-500 py-2">
                <input
                    type="text"
                    placeholder="Enter a word"
                    className="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                />
                <button type="submit"
                        className="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded">
                    Submit
                </button>
            </form>
        </div>
    );
};

export default WordInput;
