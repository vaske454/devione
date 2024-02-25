import { Link, Head } from '@inertiajs/react';
import WordInput from '../Components/WordInput';

export default function Welcome() {
    return (
        <>
            <Head title="Welcome">
                <link rel="shortcut icon" href="/favicon.png" type="image/png"/>
            </Head>
            <div className="welcome-container">
                <h1 className="welcome-title">Welcome to the Word Game!</h1>
                <div className="scoring-rules-container">
                    <h2 className="scoring-rules-title">Scoring Rules:</h2>
                    <p className="scoring-rules-description">Score is calculated based on the following rules:</p>
                    <ul className="scoring-rules-list">
                        <li className="scoring-rules-item"> - <strong>1</strong> point for each unique letter.</li>
                        <li className="scoring-rules-item"> - <strong>3</strong> extra points if the word is a palindrome.</li>
                        <li className="scoring-rules-item"> - <strong>2</strong> extra points if the word is "almost palindrome".</li>
                    </ul>
                </div>
                <WordInput/>
            </div>
        </>
    );
}
