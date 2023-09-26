import React from 'react'

const PageContainer = ({children}) => {
  return (
    <div className="py-2">
    <div className="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">{children}</div>
        </div>
    </div>
</div>
  )
}

export default PageContainer
